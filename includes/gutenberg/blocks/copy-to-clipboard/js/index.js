!function(){"use strict";var t=wp.blocks;function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},e(t)}function r(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,o)}return r}function o(t,r,o){var n;return n=function(t,r){if("object"!=e(t)||!t)return t;var o=t[Symbol.toPrimitive];if(void 0!==o){var n=o.call(t,r||"default");if("object"!=e(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===r?String:Number)(t)}(r,"string"),(r="symbol"==e(n)?n:String(n))in t?Object.defineProperty(t,r,{value:o,enumerable:!0,configurable:!0,writable:!0}):t[r]=o,t}var n=JSON.parse('{"$schema":"https://json.schemastore.org/block.json","apiVersion":3,"name":"bm/copy-to-clipboard","title":"Copy to Clipboard","description":"Allow user to copy text to clipboard.","version":"1.0.0","icon":"clipboard","usesContext":["postId","postType","queryId"],"attributes":{"content":{"type":"string","default":""},"buttonText":{"type":"string","default":"Copy to Clipboard"},"buttonTextCopied":{"type":"string","default":"Copied!"}},"supports":{"color":{"background":true,"text":true},"typography":{"fontSize":true,"lineHeight":true,"textAlign":true,"__experimentalDefaultControls":{"fontSize":true}},"spacing":{"margin":true,"padding":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalSkipSerialization":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}}},"category":"blocks-monster","textdomain":"blocks-monster","style":"file:./css/style.css","editorScript":"file:./js/index.js","script":["jquery","file:./js/frontend.js"]}');function i(t){var e,r,o="";if("string"==typeof t||"number"==typeof t)o+=t;else if("object"==typeof t)if(Array.isArray(t)){var n=t.length;for(e=0;e<n;e++)t[e]&&(r=i(t[e]))&&(o&&(o+=" "),o+=r)}else for(r in t)t[r]&&(o&&(o+=" "),o+=r);return o}var l=function(){for(var t,e,r=0,o="",n=arguments.length;r<n;r++)(t=arguments[r])&&(e=i(t))&&(o&&(o+=" "),o+=e);return o},a=wp.components,u=wp.blockEditor,s=wp.i18n,c=function(t){var e=t.attributes,r=e.content,o=e.buttonText,n=e.buttonTextCopied,i=t.setAttributes,c=t.className,p=l(c),b=(0,u.useBlockProps)({className:p});return wp.element.createElement("div",b,wp.element.createElement(u.InspectorControls,null,wp.element.createElement(a.PanelBody,null,wp.element.createElement(a.TextControl,{label:(0,s.__)("Button Text Copied","blocks-monster"),value:n,onChange:function(t){return i({buttonTextCopied:t})}}),wp.element.createElement(a.TextareaControl,{label:(0,s.__)("Content to copy","blocks-monster"),value:r,onChange:function(t){return i({content:t})},help:(0,s.__)("This is the content that will be copied to the clipboard.","blocks-monster")}))),wp.element.createElement(u.RichText,{"aria-label":(0,s.__)("Button text","blocks-monster"),as:"button",placeholder:o||(0,s.__)("Add text…","blocks-monster"),value:o,onChange:function(t){return i({buttonText:t})},withoutInteractiveFormatting:!0,identifier:"buttonText"}))};!function(e){if(e){var n=e.metadata,i=e.settings,l=e.name;(0,t.registerBlockType)(function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?r(Object(n),!0).forEach((function(e){o(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):r(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({name:l},n),i)}}({name:n.name,metadata:n,settings:{icon:"list-view",example:{attributes:{content:"This is the content to copy",buttonText:"Copy to Clipboard",buttonTextCopied:"Copied!"}},edit:c}})}();