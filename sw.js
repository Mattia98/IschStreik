var CACHE_NAME = 'is-cache-v5';
var urlsToCache = [
  'media/logos/en_GB.svg',
  'media/logos/de_DE.svg',
  'media/logos/it_IT.svg',
  'media/sandwitch.svg'
];

/**
 * ServiceWorkerStorage by RyotaSugawara
 * Including the code here is required until browsers support importing js classes via "import"
 */

const IDB_TRANSACTION_MODE = {
  readonly: 'readonly',
  readwrite: 'readwrite',
  versionchange: 'versionchange'
};

function promisify(idbRequest) {
  return new Promise(function(resolve, reject) {
    idbRequest.onsuccess = function() {
      resolve(idbRequest.result);
    };
    idbRequest.onerror = reject;
  });
}

class ServiceWorkerStorage {
  constructor(db_name, version) {
    if (typeof db_name !== 'string') throw new TypeError('db_name must be string.');
    if (typeof version !== 'number') throw new TypeError('version must be number.');
    const VERSION = version;
    this.DB_NAME = db_name;
    this.STORE_NAME = 'sw_storage';

    const db = self.indexedDB.open(this.DB_NAME, VERSION);
    db.onupgradeneeded = event => {
      const _db = event.target.result;
      if (_db.objectStoreNames && _db.objectStoreNames.contains(this.STORE_NAME)) return;
      _db.createObjectStore(this.STORE_NAME);
    };
    this.__db = promisify(db);
  }

  _accessAsyncStore(mode) {
    return this.__db.then(db => {
      const transaction = db.transaction(this.STORE_NAME, mode);
      return transaction.objectStore(this.STORE_NAME);
    });
  }

  length() {
    return this._accessAsyncStore(IDB_TRANSACTION_MODE.readonly)
      .then(store => promisify(store.getAllKeys()))
      .then(keys => keys.length);
  }

  key(idx) {
    if (!arguments.length) return Promise.reject(new TypeError('Failed to execute "key" on "Storage"'));
    if (typeof idx !== 'number') idx = 0;
    return this._accessAsyncStore(IDB_TRANSACTION_MODE.readonly)
      .then(store => promisify(store.getAllKeys()))
      .then(keys => keys[idx] || null);
  }

  getItem(key) {
    return this._accessAsyncStore(IDB_TRANSACTION_MODE.readonly)
      .then(store => store.get(key))
      .then(promisify);
  }
  setItem(key, value) {
    return this._accessAsyncStore(IDB_TRANSACTION_MODE.readwrite)
      .then(store => store.put(value, key))
      .then(promisify);
  }
  removeItem(key) {
    return this._accessAsyncStore(IDB_TRANSACTION_MODE.readwrite)
      .then(store => store['delete'](key))
      .then(promisify);
  }
  clear() {
    return this.__db
      .then(db => {
        const transaction = db.transaction(db.objectStoreNames, IDB_TRANSACTION_MODE.readwrite);
        const q = [];
        for (let i = 0, len = db.objectStoreNames.length; i < len; i++) {
          let store_name = db.objectStoreNames[i];
          q.push(promisify(transaction.objectStore(store_name).clear()));
        }
        return Promise.all(q);
      });
  }
}

/**
 * END of ServiceWorkerStorage
 */

self.addEventListener('install', e => {
  // Perform install steps
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('activate', e => {
  console.log("activate");
  const publicKey = urlB64ToUint8Array('BE90HmIQXF4Yp_S6gETYlFuV0mKohszQchwiSQ0BmmkhO07ZnssO6lIehBTtmy-6wi2WhDWIY0x5wuy3pIQzHF0');
  self.registration.pushManager.subscribe({  
    userVisibleOnly: true,  
    applicationServerKey: publicKey  
  }).then(sendSubscriptionToServer).catch(console.error);
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request)
      .then(function(response) {
        // Cache hit - return response
        if (response)
          return response;
        return fetch(e.request);
    })
  );
});

self.addEventListener('notificationclick', e => {
  clients.openWindow("/?site=company&id="+e.notification.data);
  e.notification.close();  
});

self.addEventListener('push', e => {
  console.log(e);
  fetch('API/?action=getCompanies').then(response => {return response.json();}).then((companies) => {
    if(companies.length == 0)
      reject("No companies");
    getSelectedCompanies().then(console.log);
    getSelectedCompanies().then((selCompanies) => {
      let interestedCompanies = companies.filter((obj) => selCompanies.includes(obj.cid+""));
      console.log(interestedCompanies);
      interestedCompanies.forEach(makeNotificationFromCompany);
    });
  });
});

const makeNotificationFromCompany = (company) => {
    let options = {
        body: company.name+' is striking!',
        icon: '../media/logos/companies/'+company.nameCode+'.png',
        badge: '../media/icons/favicon/favicon transparent.png',
        "vibrate": [50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50],
        data:	company.cid
    };
    self.registration.showNotification("Strike!", options);
};

const urlB64ToUint8Array = (base64String) => {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = self.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
};

const sendSubscriptionToServer = (subscription) => {
  console.log(subscription);
  swStorage.setItem("endpoint", subscription.endpoint);
  fetch("API/?action=submitPushSubscription&surl="+subscription.endpoint, {
    method: 'GET'
  }).then(console.log).catch(console.error);
};

const swStorage = new ServiceWorkerStorage('settings-storage', 1);

const getSelectedCompanies = () => swStorage.getItem("selected_companies").then(JSON.parse).then((r) => {return r;}).catch(() => {return [];});

const setSelectedCompanies = (companies) => swStorage.setItem("selected_companies", JSON.stringify(companies));
