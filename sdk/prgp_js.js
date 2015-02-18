function PGAnalytics() {
    this.sc = "pgs";
    this.pc = "pg";
    this.st = 30 * 60;
    this.pg = "";
    this.bu = "https://apis.personagraph.com/personagraph/_pg.gif";

    this.createCookie = function (name, value, expiry) {
        if (expiry) {
            var date = new Date();
            date.setTime(date.getTime() + (expiry * 1000));
            var expires = "expires=" + date.toGMTString();
        }
        else {
            var expires = "";
        }
        document.cookie = name + "=" + value + "; " + expires + ";path=/;";
    }

    this.getCookie = function(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) {
                    c_end = document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }

    this.s4 = function() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    this.createID = function() {
        return this.s4() + this.s4() + '-' + this.s4() + '-' + this.s4() + '-' +
            this.s4() + '-' + this.s4() + this.s4() + this.s4();
    }

    this.createPG = function() {
        return this.createID()
    }
    this.sendEvent = function(id, sub_type, url, shouldRedirect, tag) {
        var data = {};
        data.sdk_ver = "js";
        data.sub_type = sub_type;
        data.session = id;   
        data.tag_key = this.createID();
        if (tag != undefined){
            data.tag = tag;    
        }
        else{
            data.tag = "";
        }
        
        data.duration = 0;
        data.agg_direction = 1; 
        data.last_change_ts = parseInt(new Date().getTime() / 1000);
        data.time_zone = new Date().getTimezoneOffset();
        var et = 'session';
        if (url != undefined) {
            data.source = "web";
            data.uri = url;
            et = 'crawl';
        }
        this.dropPixel("d=" + encodeURIComponent(JSON.stringify(data)) + "&et=" + et, url, shouldRedirect);
    }
    this.recordClick = function(tag) {
        this.sendEvent(this.session_id, 4, undefined, undefined, tag);
    }

    this.prepURL = function(v) {
        var dn = document.domain.split('.').slice(-2).join(".");
        return this.bu+"?"+v+"&t="+dn+"&a="+pgaid+"&u="+this.pg+"&ft="+document.URL;
        // return this.bu + "?" + v + "&t=personagraph" + "&a=" + pgaid + "&u=" + this.pg + "&ft=" + document.URL;
    }
    this.dropPixel = function(v, url, shouldRedirect) {
        var img = document.createElement("img");
        img.src = this.prepURL(v);
        img.style.display = "none";
        if (shouldRedirect != undefined) {
            img.onload = function () {
                document.location = url;
            }
            img.onerror = function() {
                document.location = url;   
            }
        }
        document.getElementsByTagName("body")[0].appendChild(img);
    }


    this.handleUser = function () {
        this.pg = this.getCookie(this.pc);
        if (this.pg == "") {
            this.pg = this.createPG();
            this.createCookie(this.pc, this.pg, 10 * 365 * 24 * 3600);
        }
    }

    this.createSession = function() {
        this.session_id = this.createID();
        this.sendEvent(this.session_id, 1);
        setTimeout(function () { 
            pga.sendEvent(pga.session_id, 1, document.URL);
            pga.createCookie(pga.sc, pga.session_id, pga.st);
            setInterval(pga.createSession, pga.st * 1000);
        }, 2000);
    }

    this.handleSession = function () {
        this.createSession();
    }

    this.sendURL = function(url) {
        this.sendEvent(this.getCookie(this.sc), 1, url, true)
    }

    this.sendFBToken = function(token) {
        this.dropPixel("fb=" + token);

    }

    this.firstPush = function(){
        if (pgaid != undefined){
            this.handleUser();
            this.createSession();
        }

    }

    this.setAccountID = function (aid) {
        if (aid != undefined && aid != "") {
            pgaid = aid;
        }
    }

    this.setSessionTimeOut = function(time) {
        if (time != undefined && !isNaN(time)) {
            time = Number(time);
            if (time > 0) {
                this.st = time;
            }
        }
    }
    this.firstPush();
}

var pga = new PGAnalytics()
