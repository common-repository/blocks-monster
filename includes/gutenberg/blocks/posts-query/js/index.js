!function(){"use strict";var e=wp.blocks;function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}function r(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function n(e,r,n){var o;return o=function(e,r){if("object"!=t(e)||!e)return e;var n=e[Symbol.toPrimitive];if(void 0!==n){var o=n.call(e,r||"default");if("object"!=t(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===r?String:Number)(e)}(r,"string"),(r="symbol"==t(o)?o:String(o))in e?Object.defineProperty(e,r,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[r]=n,e}var o=JSON.parse('{"$schema":"https://json.schemastore.org/block.json","apiVersion":3,"name":"bm/posts-query","title":"Posts Query","description":"Posts Query","version":"0.0.2","icon":"smiley","keywords":["posts","list"],"providesContext":{"postType":"postType"},"attributes":{"postType":{"type":"string","default":"post"},"perPage":{"type":"number","default":10},"order":{"type":"string","default":"asc"},"orderBy":{"type":"string","default":"date"}},"supports":{"color":{"background":true,"text":true,"link":true,"enableContrastChecker":true,"gradients":true},"typography":{"fontSize":true,"lineHeight":true,"textAlign":true,"__experimentalDefaultControls":{"fontSize":true}},"spacing":{"margin":true,"padding":true},"align":true},"category":"blocks-monster","textdomain":"blocks-monster","style":"file:./css/style.css","editorScript":"file:./js/index.js"}');function l(e){var t,r,n="";if("string"==typeof e||"number"==typeof e)n+=e;else if("object"==typeof e)if(Array.isArray(e)){var o=e.length;for(t=0;t<o;t++)e[t]&&(r=l(e[t]))&&(n&&(n+=" "),n+=r)}else for(r in e)e[r]&&(n&&(n+=" "),n+=r);return n}var a=function(){for(var e,t,r=0,n="",o=arguments.length;r<o;r++)(e=arguments[r])&&(t=l(e))&&(n&&(n+=" "),n+=t);return n},s=wp.components,i=wp.blockEditor,c=wp.data,p=wp.coreData,u=wp.i18n,m=wp.element,b=function(e){var t=e.attributes,r=t.postType,n=t.perPage,o=t.order,l=t.orderBy,b=e.setAttributes,y=e.className,f=function(){var e=(0,c.useSelect)((function(e){return e("core").getPostTypes({per_page:-1})}),[]);return(0,m.useMemo)((function(){var t=["attachment"];return null==e?void 0:e.filter((function(e){var r=e.viewable,n=e.slug;return r&&!t.includes(n)}))}),[e])}();console.log("post types",f);var g={per_page:n,context:"view",orderby:l,order:o},d=(0,p.useEntityRecords)("postType",r,g),_=d.records,v=d.isResolving,w=a(y,{"bm-posts-list--horizontal":!0}),k=(0,i.useBlockProps)({className:w});return wp.element.createElement(React.Fragment,null,wp.element.createElement(i.InspectorControls,null,wp.element.createElement(s.PanelBody,{title:(0,u.__)("Query","blocks-monster")},f?f.length?wp.element.createElement(React.Fragment,null,wp.element.createElement(s.SelectControl,{label:(0,u.__)("Post Type","blocks-monster"),value:r,options:f.map((function(e){return{value:e.slug,label:e.labels.name}})),onChange:function(e){return b({postType:e})}}),wp.element.createElement(s.__experimentalNumberControl,{label:(0,u.__)("Per Page","blocks-monster"),value:n,onChange:function(e){return b({perPage:e})}}),wp.element.createElement(s.__experimentalToggleGroupControl,{label:(0,u.__)("Order By","blocks-monster"),value:l,onChange:function(e){return b({orderBy:e})}},[{value:"title",label:(0,u.__)("Title","blocks-monster")},{value:"date",label:(0,u.__)("Date","blocks-monster")},{value:"modified",label:(0,u.__)("Modified","blocks-monster")},{value:"author",label:(0,u.__)("Author","blocks-monster")}].map((function(e){var t=e.value,r=e.label;return wp.element.createElement(s.__experimentalToggleGroupControlOption,{key:t,value:t,label:r})}))),wp.element.createElement(s.__experimentalToggleGroupControl,{label:(0,u.__)("Order","blocks-monster"),value:o,onChange:function(e){return b({order:e})}},[{value:"asc",label:(0,u.__)("ASC","blocks-monster")},{value:"desc",label:(0,u.__)("DESC","blocks-monster")}].map((function(e){var t=e.value,r=e.label;return wp.element.createElement(s.__experimentalToggleGroupControlOption,{key:t,value:t,label:r})})))):wp.element.createElement("p",{className:"bm-terms-list__empty"},(0,u.__)("No posts found","blocks-monster")):wp.element.createElement(s.Placeholder,{icon:wp.element.createElement(s.Spinner,null),label:(0,u.__)("Loading Post Types","blocks-monster")},wp.element.createElement(s.VisuallyHidden,null,(0,u.__)("Loading Post Types","blocks-monster"))))),wp.element.createElement("div",k,v?wp.element.createElement(s.Placeholder,{icon:wp.element.createElement(s.Spinner,null),label:(0,u.__)("Loading Posts","blocks-monster")},wp.element.createElement(s.VisuallyHidden,null,(0,u.__)("Loading Posts","blocks-monster"))):_&&_.length&&!v?wp.element.createElement("ul",{className:"bm-posts-list__items"},_.map((function(e,t){var r=e.id,n=e.title.rendered,o=e.link;return wp.element.createElement("li",{key:r,className:"bm-posts-list__item"},wp.element.createElement("a",{href:o,target:"_blank",rel:"noreferrer noopener",className:"bm-posts-list__name"},n))}))):wp.element.createElement("p",{className:"bm-posts-list__empty"},(0,u.__)("No posts found","blocks-monster"))))};!function(t){if(t){var o=t.metadata,l=t.settings,a=t.name;(0,e.registerBlockType)(function(e){for(var t=1;t<arguments.length;t++){var o=null!=arguments[t]?arguments[t]:{};t%2?r(Object(o),!0).forEach((function(t){n(e,t,o[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(o)):r(Object(o)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(o,t))}))}return e}({name:a},o),l)}}({name:o.name,metadata:o,settings:{icon:"list-view",example:{postType:"post",perPage:10,order:"asc",orderBy:"name"},edit:b}})}();