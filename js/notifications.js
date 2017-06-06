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
/* END of ServiceWorkerStorage */

(() => {
    "use strict";

	const init = () => {
        $('#settingsswitcher').checked = localStorage.getItem("notifications_status") === 'true';
        $('#settingsswitcher').addEventListener('change', notificationSwitch);
        if(localStorage.getItem("notifications_status") === 'true') {
            $('.bell').addEventListener('click', bellClicked);
            updateBell($('.bell'));
            $('#div-bell').style.display = "block";
        }
	};
	
    const notificationSwitch = (e) => {
        console.log("change");
        if($('#settingsswitcher').checked) {
            localStorage.setItem("notifications_status", true);
            Notification.requestPermission().then((status) => {
              if(status == "granted") {
                if ('serviceWorker' in navigator) {
                    console.log("registering");
                    navigator.serviceWorker.register('../sw.js').then(function(registration) {
                        // Registration was successful
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }).catch(function(err) {
                        // registration failed :(
                        console.log('ServiceWorker registration failed: ', err);
                        reject(err);
                    });
                }
                getSelectedCompanies().then((companies) => {
                    console.log(companies);
                    if(companies.length == 0)
                        setSelectedCompanies(["0"]);
                });
                $('.bell').addEventListener('click', bellClicked);
	             updateBell($('.bell'));
	             $('#div-bell').style.display = "block";
              } else {
                reject("Unknown Error");
              }
            }).catch(() => {
              localStorage.setItem("notifications_status", false);
              $('#settingsswitcher').checked = false;
            });
        } else {
            localStorage.setItem("notifications_status", false);
            $('#settingsswitcher').checked = false;
        }
    };

    const bellClicked = (e) => {
        let id = e.target.dataset.cid;
        getSelectedCompanies().then((companies) => {
            if(companies.includes(id))
                setSelectedCompanies(companies.filter((obj) => obj != id));
            else
                setSelectedCompanies(companies.concat([id]));
            updateBell(e.target);
        });
    };

    const updateBell = (bell) => {
        let id = bell.dataset.cid;
        getSelectedCompanies().then((companies) => {
            if(companies.includes(id))
                bell.innerHTML = "notifications_active";
            else
                bell.innerHTML = "notifications_off";
        });
    };

    const swStorage = new ServiceWorkerStorage('settings-storage', 1);
    
    const getSelectedCompanies = () => swStorage.getItem("selected_companies").then(JSON.parse).then((r) => {return r;}).catch(() => {return [];});
   
    const setSelectedCompanies = (companies) => swStorage.setItem("selected_companies", JSON.stringify(companies));

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
