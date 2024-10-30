!function(){"use strict";var e=wp.blocks;function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}function n(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,o)}return n}function o(e,n,o){var r;return r=function(e,n){if("object"!=t(e)||!e)return e;var o=e[Symbol.toPrimitive];if(void 0!==o){var r=o.call(e,n||"default");if("object"!=t(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===n?String:Number)(e)}(n,"string"),(n="symbol"==t(r)?r:String(r))in e?Object.defineProperty(e,n,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[n]=o,e}var r=JSON.parse('{"$schema":"https://json.schemastore.org/block.json","apiVersion":3,"name":"bm/social-share","title":"Social Share","description":"Allow user to share content on social media.","version":"0.0.1","icon":"share","usesContext":["postId","postType","queryId"],"attributes":{"label":{"type":"string","default":"Share on:"},"showLabel":{"type":"boolean","default":true},"facebook":{"type":"boolean","default":true},"twitter":{"type":"boolean","default":true},"whatsapp":{"type":"boolean","default":true}},"supports":{"color":{"background":true,"text":true},"typography":{"fontSize":true,"lineHeight":true,"textAlign":true,"__experimentalDefaultControls":{"fontSize":true}},"spacing":{"margin":true,"padding":true}},"category":"blocks-monster","textdomain":"blocks-monster","style":"file:./css/style.css","editorScript":"file:./js/index.js"}');function a(e){var t,n,o="";if("string"==typeof e||"number"==typeof e)o+=e;else if("object"==typeof e)if(Array.isArray(e)){var r=e.length;for(t=0;t<r;t++)e[t]&&(n=a(e[t]))&&(o&&(o+=" "),o+=n)}else for(n in e)e[n]&&(o&&(o+=" "),o+=n);return o}var l=function(){for(var e,t,n=0,o="",r=arguments.length;n<r;n++)(e=arguments[n])&&(t=a(e))&&(o&&(o+=" "),o+=t);return o},c=wp.components,i=wp.blockEditor,s=wp.i18n,p=function(e){return e.preventDefault()},m=function(e){var t=e.text,n=e.link;return wp.element.createElement("a",{onClick:p,className:"bm-social-share__facebook",href:"https://www.facebook.com/sharer/sharer.php?u=".concat(encodeURIComponent(n),"&quote=").concat(encodeURIComponent(t))},wp.element.createElement(c.SVG,{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",fill:"none",viewBox:"0 0 24 24"},wp.element.createElement(c.Path,{fill:"#425993","fill-rule":"evenodd",d:"M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h7v-7h-2v-3h2V8.5A3.5 3.5 0 0115.5 5H18v3h-2a1 1 0 00-1 1v2h3v3h-3v7h4a2 2 0 002-2V5a2 2 0 00-2-2z","clip-rule":"evenodd"})))},u=function(e){var t=e.text,n=e.link;return wp.element.createElement("a",{onClick:p,className:"bm-social-share__whatsapp",href:"https://api.whatsapp.com/send?text=".concat(encodeURIComponent(t),"%0A").concat(encodeURIComponent(n))},wp.element.createElement(c.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 240 241.19"},wp.element.createElement(c.Path,{fill:"#25d366",d:"M205,35.05A118.61,118.61,0,0,0,120.46,0C54.6,0,1,53.61,1,119.51a119.5,119.5,0,0,0,16,59.74L0,241.19l63.36-16.63a119.43,119.43,0,0,0,57.08,14.57h0A119.54,119.54,0,0,0,205,35.07v0ZM120.5,219A99.18,99.18,0,0,1,69.91,205.1l-3.64-2.17-37.6,9.85,10-36.65-2.35-3.76A99.37,99.37,0,0,1,190.79,49.27,99.43,99.43,0,0,1,120.49,219ZM175,144.54c-3-1.51-17.67-8.71-20.39-9.71s-4.72-1.51-6.75,1.51-7.72,9.71-9.46,11.72-3.49,2.27-6.45.76-12.63-4.66-24-14.84A91.1,91.1,0,0,1,91.25,113.3c-1.75-3-.19-4.61,1.33-6.07s3-3.48,4.47-5.23a19.65,19.65,0,0,0,3-5,5.51,5.51,0,0,0-.24-5.23C99,90.27,93,75.57,90.6,69.58s-4.89-5-6.73-5.14-3.73-.09-5.7-.09a11,11,0,0,0-8,3.73C67.48,71.05,59.75,78.3,59.75,93s10.69,28.88,12.19,30.9S93,156.07,123,169c7.12,3.06,12.68,4.9,17,6.32a41.18,41.18,0,0,0,18.8,1.17c5.74-.84,17.66-7.21,20.17-14.18s2.5-13,1.75-14.19-2.69-2.06-5.7-3.59l0,0Z"})))},b=function(e){var t=e.text,n=e.link;return wp.element.createElement("a",{onClick:p,className:"bm-social-share__twitter",href:"https://twitter.com/intent/tweet?text=".concat(encodeURIComponent(t),"&url=").concat(encodeURIComponent(n))},wp.element.createElement(c.SVG,{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",fill:"none",viewBox:"0 0 24 24"},wp.element.createElement(c.Path,{fill:"#4BA8F5",d:"M22.92 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.83 4.5 17.72 4 16.46 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98-3.56-.18-6.73-1.89-8.84-4.48-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 01-1.93.07 4.28 4.28 0 004 2.98 8.521 8.521 0 01-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.9 20.29 6.16 21 8.58 21c7.88 0 12.21-6.54 12.21-12.21 0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"})))},f=function(e){var t=e.attributes,n=t.label,o=t.showLabel,r=t.facebook,a=t.twitter,p=t.whatsapp,f=e.setAttributes,h=e.className,w=l(h),d=(0,i.useBlockProps)({className:w});return wp.element.createElement(React.Fragment,null,wp.element.createElement(i.InspectorControls,null,wp.element.createElement(c.PanelBody,null,wp.element.createElement(c.ToggleControl,{label:(0,s.__)("Show Label","blocks-monster"),checked:o,onChange:function(e){return f({showLabel:e})}}),wp.element.createElement(c.ToggleControl,{label:(0,s.__)("WhatsApp","blocks-monster"),checked:p,onChange:function(e){return f({whatsapp:e})}}),wp.element.createElement(c.ToggleControl,{label:(0,s.__)("Facebook","blocks-monster"),checked:r,onChange:function(e){return f({facebook:e})}}),wp.element.createElement(c.ToggleControl,{label:(0,s.__)("Twitter","blocks-monster"),checked:a,onChange:function(e){return f({twitter:e})}}))),wp.element.createElement("div",d,o&&wp.element.createElement(i.RichText,{tagName:"span","aria-label":(0,s.__)("Label","blocks-monster"),placeholder:(0,s.__)("Label","blocks-monster"),value:n,onChange:function(e){return f({label:e})},withoutInteractiveFormatting:!0,identifier:"text",className:"bm-social-share__label"}),p&&wp.element.createElement(u,{text:"ok",link:"#"}),r&&wp.element.createElement(m,{text:"ok",link:"#"}),a&&wp.element.createElement(b,{text:"ok",link:"#"})))};!function(t){if(t){var r=t.metadata,a=t.settings,l=t.name;(0,e.registerBlockType)(function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?n(Object(r),!0).forEach((function(t){o(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):n(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({name:l},r),a)}}({name:r.name,metadata:r,settings:{icon:"list-view",example:{attributes:{content:"This is the content to copy",buttonText:"Copy to Clipboard",buttonTextCopied:"Copied!"}},edit:f}})}();