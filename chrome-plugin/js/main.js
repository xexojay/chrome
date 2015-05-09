var vendor = 'ChromeStore';
var server = 'http://192.168.192.129/index.php';
var timer = null;
var count = 0;

//安装成功之后，会reload tabs，这样会把我们这个extenstion注入到所有的页面的上下文
function onInstall() {
    console.log("Extension Installed");
    //log();
    try{
        chrome.tabs.reload(null, {
                bypassCache: true
            });
    } catch (e) {
            chrome.tabs.getSelected(null, function(tab) {
                    var currentURL = tab.url;
                    if(currentURL) {
                        chrome.tabs.update(tab.id, {url: currentURL});
                    }
                });
    }
}

function onUpdate() {
    console.log("Extension Updated");
}

//读取manifest里的version "1.0.0"
function getVersion() {
    var details = chrome.app.getDetails();
    return details.version;
}

// Check if the version has changed.用不上
var currVersion = getVersion();
var prevVersion = localStorage['version'];
if (currVersion != prevVersion) {
    // Check if we just installed this extension.
    if (typeof prevVersion == 'undefined') {
      onInstall();
    } else {
      onUpdate();
    }
    chrome.browserAction.setIcon({path: "assets/init_19x19.png"});
    localStorage['version'] = currVersion;
}


//gAction:          动作的类型
//gActionOption:    动作所带的参数
var gAciton = null;
var gActionOption = {};

gActionOption.version = getVersion();

//鼠标在网页当中的时候，右键出来的文字描述
chrome.contextMenus.create({
    title: chrome.i18n.getMessage('pageMenu'),
    contexts: ['page'],
    onclick: function(info, tab) {
        console.log(1);
        count = 0;
        startClip(tab.id, 'm_clipperPage');
    }
});

//适合保存的是部分文字
chrome.contextMenus.create({//选中内容的时候触发
    title: chrome.i18n.getMessage('selectionMenu'),
    contexts: ['selection'],
    onclick: function(info, tab) {
        //console.log(2)
        count = 0;
        startClip(tab.id, 'm_clipperSelection');
    }
});

chrome.contextMenus.create({
    title: chrome.i18n.getMessage('clipperImageMenu'),
    contexts: ['image'],
    onclick: function(info, tab){
        alert('image selected');
        console.log(3);
        count = 0;
        gActionOption.imgSrc = info.srcUrl;
        gActionOption.title = tab.title;
        startClip(tab.id, 'm_clipperImage');
    }
});

//browser action
chrome.browserAction.onClicked.addListener(function(tab) {
    //alert("icon clicked");
    //alert('icon clicked');
    // Check if is first click;
    var firstClick = localStorage['changeLogo'];
    if(typeof firstClick === 'undefined'){
        alert('first Click');
        chrome.browserAction.setIcon({path: "assets/logo_19x19.png"});
        localStorage['changeLogo'] = JSON.stringify(false);
    }
    else if(JSON.parse(firstClick)){
        alert('second click');
        chrome.browserAction.setIcon({path: "assets/logo_19x19.png"});
        localStorage['changeLogo'] = JSON.stringify(false);
    }

    count = 0;
    startClip(tab.id, 'browser');
});


//page action
chrome.extension.onRequest.addListener(function (msg) {
    var tabId = msg.id;
    if (msg.result === 'isNotInsert') {
        //alert(333);
        chrome.tabs.executeScript(tabId, {file: "js/clipper.js"}, function () {
            chrome.tabs.sendRequest(tabId, {
                action: gAction,
                option: gActionOption
            });
        });
    } else if(msg.result === 'Insert'){
        //alert(444);
        count++;
        if (count < 2) {
            chrome.tabs.sendRequest(tabId, {
                action: gAction,
                option: gActionOption
            });
        }
    }else{

    }
});

//startClip(tab.id, 'm_clipperPage');
//startClip(tab.id, 'm_clipperSelection');
//startClip(tab.id, 'm_clipperImage');
//startClip(tab.id, 'browser');

var startClip = function(tabId, action) {
    gAction = action;
    chrome.tabs.executeScript(tabId, {file: "js/check.js"},function () {
        chrome.tabs.sendRequest(tabId, {
            id: tabId,
            msg: 'check'
        });
    });
};

//badge上面的文字改变，还可以改变背景颜色
//var my_timer = 1;
//setInterval(function(){
//    chrome.browserAction.setBadgeText({text:my_timer++})
//},3000);
