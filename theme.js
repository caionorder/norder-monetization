const NorderLoader = {
    init: function(config) {
        this.config = {
            adUnit: config.adUnit || '',
            timeout: config.timeout || 5000,
            loaderId: config.loaderId || 'joinadsloader__wrapper'
        };

        this.loader = document.querySelector('#' + this.config.loaderId);
        this.waitSlotRender = [this.config.adUnit];

        window.scrollTo({top: 0, behavior: 'smooth'});
        this.disableScroll();

        if (this.waitSlotRender.length > 0) {
            this.setupAdListener();
        } else {
            window.addEventListener("load", () => {
                this.waitFor(() => true).then(() => {
                    this.fadeOut(this.loader);
                });
            });
        }

        setTimeout(() => {
            this.fadeOut(this.loader);
        }, this.config.timeout);
    },

    fadeOut: function(div) {
        if (document.getElementById(div.id)) {
            div.addEventListener('animationend', () => {
                document.body.style.position = '';
                div.remove();
            });
            div.style = 'animation: joinadsloader-fadeOut 0.5s forwards;';
        }
        this.enableScroll();
    },

    waitFor: function(conditionFunction) {
        const poll = resolve => {
            if (conditionFunction()) resolve();
            else setTimeout(() => poll(resolve), 10);
        };
        return new Promise(poll);
    },

    setupAdListener: function() {
        window.googletag = window.googletag || {cmd: []};
        googletag.cmd.push(() => {
            googletag.pubads().addEventListener('slotOnload', event => {
                if (!event.isEmpty) {
                    this.fadeOut(this.loader);
                }
                if (Array.isArray(this.waitSlotRender) && this.waitSlotRender.includes(event.slot.getSlotElementId())) {
                    this.waitFor(() => true).then(() => {
                        this.fadeOut(this.loader);
                    });
                }
            });
        });
    },

    disableScroll: function() {
        document.body.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
    },

    enableScroll: function() {
        document.body.style.overflow = '';
        document.body.style.position = '';
        document.body.style.width = '';
    }
};

const MetaPixel = {

    init: function(config) {
        this.config = config;
        this.loadPixel();
        this.setupTracking();
        this.setupLinkTracking();
    },

    loadPixel: function() {
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        
        fbq.disablePushState = true;
        fbq('init', this.config.pixelId);
    },

    setupTracking: function() {
        const getCookie = name => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            return parts.length === 2 ? parts.pop().split(';').shift() : null;
        };
    
        const getQueryParam = param => new URLSearchParams(window.location.search).get(param);
    
        const getOrCreateExternalIdAndClickIds = () => {
            const cookieName = 'external_data';
            let { external_id: externalId, fbclid, gclid } = JSON.parse(getCookie(cookieName) || '{}');
    
            if (!externalId) externalId = `${Math.random().toString(36).substr(2, 9)}${Date.now()}`;
            if (!fbclid) fbclid = getQueryParam('fbclid');
            if (!gclid) gclid = getQueryParam('gclid');
    
            const cookieData = { external_id: externalId, ...(fbclid && { fbclid }), ...(gclid && { gclid }) };
            document.cookie = `${cookieName}=${JSON.stringify(cookieData)}; path=/; max-age=${6 * 60 * 60}`;
    
            return { externalId, fbclid, gclid };
        };
    
        const sendConversionData = async (data, eventName) => {
            try {
                const response = await fetch('https://cloud.norder.dev/conversion/save', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                if (result.status === "success" && result.data?.event_id) {
                    if (typeof fbq === 'function') {
                        fbq('track', eventName, {}, { eventID: result.data.event_id, external_id: result.data.external_id });
                    } else {
                        console.warn('Facebook Pixel (fbq) não está disponível');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        };
    
        window.trackEvent = async (eventName, pixelId, additionalData = {}) => {
            const { externalId, fbclid, gclid } = getOrCreateExternalIdAndClickIds();
            const [fbc, fbp] = ['_fbc', '_fbp'].map(getCookie);
            const ipv6 = null;
    
            const data = {
                event_name: eventName,
                event_source_url: window.location.href,
                external_id: externalId,
                page_title: document.title,
                page_url: document.referrer,
                pixel_id: pixelId,
                ...(ipv6 && { ipv6 }),
                ...(fbclid && { fbclid }),
                ...(gclid && { gclid }),
                ...(fbc && { fbc }),
                ...(fbp && { fbp }),
                ...additionalData
            };
    
            await sendConversionData(data, eventName);
        };

        // Track initial PageView
        this.trackPageView();
    },

    trackPageView: function() {
        trackEvent('ViewContent', this.config.pixelId, {
            'currency': 'USD',
            'value': '0.01',
        });
    },

    setupLinkTracking: function() {
        document.addEventListener('DOMContentLoaded', () => {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', () => {
                    trackEvent('ClickLink', this.config.pixelId, {
                        'currency': 'USD',
                        'value': '0.01',
                    });
                });
            });
        });
    }
};

// theme initialization
function initializeTheme(config) {
    if (config.NorderLoader) {
        NorderLoader.init(config.NorderLoader);
    }

    if (config.metaPixel) {
        MetaPixel.init(config.metaPixel);
    }
}

// Exportar o objeto para uso global
window.NorderLoader = NorderLoader;
window.MetaPixel = MetaPixel;
