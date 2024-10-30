!function(){"use strict";var e=wp.blocks;function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}function r(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function n(e,r,n){var o;return o=function(e,r){if("object"!=t(e)||!e)return e;var n=e[Symbol.toPrimitive];if(void 0!==n){var o=n.call(e,r||"default");if("object"!=t(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===r?String:Number)(e)}(r,"string"),(r="symbol"==t(o)?o:String(o))in e?Object.defineProperty(e,r,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[r]=n,e}var o=JSON.parse('{"$schema":"https://json.schemastore.org/block.json","apiVersion":3,"name":"bm/google-play-store","title":"Google Play Store Button","description":"Allow user to add Google Play Store Button.","version":"1.0.0","icon":"store","attributes":{"link":{"type":"string","default":"https://play.google.com/store/apps/details?id=com.google.android.apps.maps"},"alt":{"type":"string","default":"Google Play Store"},"width":{"type":"number","default":160},"target":{"type":"string","default":"_blank"}},"category":"blocks-monster","textdomain":"blocks-monster","editorScript":"bm-google-play-store"}');function l(e){var t,r,n="";if("string"==typeof e||"number"==typeof e)n+=e;else if("object"==typeof e)if(Array.isArray(e)){var o=e.length;for(t=0;t<o;t++)e[t]&&(r=l(e[t]))&&(n&&(n+=" "),n+=r)}else for(r in e)e[r]&&(n&&(n+=" "),n+=r);return n}var a=function(){for(var e,t,r=0,n="",o=arguments.length;r<o;r++)(e=arguments[r])&&(t=l(e))&&(n&&(n+=" "),n+=t);return n},i=wp.components,s=wp.blockEditor,c=wp.i18n;function p(){return p=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},p.apply(this,arguments)}var u=function(e){var t=e.attributes,r=t.link,n=t.alt,o=t.width,l=t.target,u=e.setAttributes,m=(e.className,(0,s.useBlockProps)({className:a({"is-target-blank":"_blank"===l}),href:r,target:l,style:{display:"inline-flex"},rel:"noopener"}));return wp.element.createElement(React.Fragment,null,wp.element.createElement(s.InspectorControls,null,wp.element.createElement(i.PanelBody,null,wp.element.createElement(i.TextControl,{label:(0,c.__)("App Link","blocks-monster"),value:r,onChange:function(e){return u({link:e})}}),wp.element.createElement(i.TextControl,{label:(0,c.__)("Alt Text","blocks-monster"),value:n,onChange:function(e){return u({alt:e})}}),wp.element.createElement(i.SelectControl,{label:(0,c.__)("Open in New Tab","blocks-monster"),value:l,options:[{label:(0,c.__)("No","blocks-monster"),value:"_self"},{label:(0,c.__)("Yes","blocks-monster"),value:"_blank"}],onChange:function(e){return u({target:e})}}),wp.element.createElement(i.__experimentalNumberControl,{label:(0,c.__)("Width","blocks-monster"),value:o,min:20,onChange:function(e){return u({width:e})}}))),wp.element.createElement("a",p({},m,{onClick:function(e){return e.preventDefault()}}),wp.element.createElement("img",{src:BMGooglePlayStore.image_url,alt:n,style:{width:"".concat(o,"px")}})))},m=function(e){var t=e.attributes,r=t.link,n=t.alt,o=t.width,l=t.target,i=s.useBlockProps.save({className:a({"is-target-blank":"_blank"===l}),href:r,target:l,style:{display:"inline-flex"},rel:"noopener"});return wp.element.createElement("a",i,wp.element.createElement("img",{src:BMGooglePlayStore.image_url,alt:n,style:{width:"".concat(o,"px")}}))};!function(t){if(t){var o=t.metadata,l=t.settings,a=t.name;(0,e.registerBlockType)(function(e){for(var t=1;t<arguments.length;t++){var o=null!=arguments[t]?arguments[t]:{};t%2?r(Object(o),!0).forEach((function(t){n(e,t,o[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(o)):r(Object(o)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(o,t))}))}return e}({name:a},o),l)}}({name:o.name,metadata:o,settings:{icon:"list-view",example:{attributes:{alt:"Google Play Store",link:"https://play.google.com/store/apps/details?id=com.google.android.apps.maps",width:160}},edit:u,save:m}})}();