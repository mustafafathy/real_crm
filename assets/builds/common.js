if(void 0===$.validator)throw new Error('jQuery Validation plugin not found. "appFormValidator" requires jQuery Validation >= v1.17.0');function confirm_delete(){var t="Are you sure you want to perform this action?";return"undefined"!=typeof app&&(t=app.lang.confirm_action_prompt),0!=confirm(t)}!function(t){var e=!1;t.fn.appFormValidator=function(n){var i=this,o={email:{remote:t.fn.appFormValidator.internal_options.localization.email_exists}},a={rules:[],messages:[],ignore:[],onSubmit:!1,submitHandler:function(e){var n=t(e);n.hasClass("disable-on-submit")&&n.find('[type="submit"]').prop("disabled",!0);var i=n.find("[data-loading-text]");if(i.length>0&&i.button("loading"),!r.onSubmit)return!0;r.onSubmit(e)}},r=t.extend({},a,n);return void 0===r.messages.email&&(r.messages.email=o.email),i.configureJqueryValidationDefaults=function(){if(e)return!0;e=!0,t.validator.setDefaults({highlight:t.fn.appFormValidator.internal_options.error_highlight,unhighlight:t.fn.appFormValidator.internal_options.error_unhighlight,errorElement:t.fn.appFormValidator.internal_options.error_element,errorClass:t.fn.appFormValidator.internal_options.error_class,errorPlacement:t.fn.appFormValidator.internal_options.error_placement}),i.addMethodFileSize(),i.addMethodExtension()},i.addMethodFileSize=function(){t.validator.addMethod("filesize",(function(t,e,n){return this.optional(e)||e.files[0].size<=n}),t.fn.appFormValidator.internal_options.localization.file_exceeds_max_filesize)},i.addMethodExtension=function(){t.validator.addMethod("extension",(function(t,e,n){return n="string"==typeof n?n.replace(/,/g,"|"):"png|jpe?g|gif",this.optional(e)||t.match(new RegExp("\\.("+n+")$","i"))}),t.fn.appFormValidator.internal_options.localization.validation_extension_not_allowed)},i.validateCustomFields=function(e){t.each(e.find(t.fn.appFormValidator.internal_options.required_custom_fields_selector),(function(){if(!t(this).parents("tr.main").length&&!t(this).hasClass("do-not-validate")&&(t(this).rules("add",{required:!0}),t.fn.appFormValidator.internal_options.on_required_add_symbol)){var e=t(this).parents("."+t.fn.appFormValidator.internal_options.field_wrapper_class).find('[for="'+t(this).attr("name")+'"]');e.length>0&&0===e.find(".req").length&&e.prepend('<small class="req text-danger">* </small>')}}))},i.addRequiredFieldSymbol=function(e){t.fn.appFormValidator.internal_options.on_required_add_symbol&&t.each(r.rules,(function(t,n){if("required"==n&&!jQuery.isPlainObject(n)||jQuery.isPlainObject(n)&&n.hasOwnProperty("required")){var i=e.find('[for="'+t+'"]');i.length>0&&0===i.find(".req").length&&i.prepend(' <small class="req text-danger">* </small>')}}))},i.configureJqueryValidationDefaults(),i.each((function(){var e=t(this);e.data("validator")&&e.data("validator").destroy(),e.validate(r),i.validateCustomFields(e),i.addRequiredFieldSymbol(e),t(document).trigger("app.form-validate",e)}))}}(jQuery),$.fn.appFormValidator.internal_options={localization:{email_exists:"undefined"!=typeof app?app.lang.email_exists:"Please fix this field",file_exceeds_max_filesize:"undefined"!=typeof app?app.lang.file_exceeds_max_filesize:"File Exceeds Max Filesize",validation_extension_not_allowed:"undefined"!=typeof app?$.validator.format(app.lang.validation_extension_not_allowed):$.validator.format("Extension not allowed")},on_required_add_symbol:!0,error_class:"text-danger",error_element:"p",required_custom_fields_selector:"[data-custom-field-required]",field_wrapper_class:"form-group",field_wrapper_error_class:"has-error",tab_panel_wrapper:"tab-pane",validated_tab_class:"tab-validated",error_placement:function(t,e){e.parent(".input-group").length||e.parents(".chk").length?e.parents(".chk").length?t.insertAfter(e.parents(".chk")):t.insertAfter(e.parent()):e.is("select")&&(e.hasClass("selectpicker")||e.hasClass("ajax-search"))?t.insertAfter(e.parents("."+$.fn.appFormValidator.internal_options.field_wrapper_class+" *").last()):t.insertAfter(e)},error_highlight:function(t){var e=$(t).closest("."+$.fn.appFormValidator.internal_options.tab_panel_wrapper);e.length&&!e.is(":visible")&&$('a[href="#'+e.attr("id")+'"]').css("border-bottom","1px solid red").css("color","red").addClass($.fn.appFormValidator.internal_options.validated_tab_class),$(t).is("select")?delay((function(){$(t).closest("."+$.fn.appFormValidator.internal_options.field_wrapper_class).addClass($.fn.appFormValidator.internal_options.field_wrapper_error_class)}),400):$(t).closest("."+$.fn.appFormValidator.internal_options.field_wrapper_class).addClass($.fn.appFormValidator.internal_options.field_wrapper_error_class)},error_unhighlight:function(t){var e=(t=$(t)).closest("."+$.fn.appFormValidator.internal_options.tab_panel_wrapper);t.closest("."+$.fn.appFormValidator.internal_options.field_wrapper_class).removeClass($.fn.appFormValidator.internal_options.field_wrapper_error_class),e.length&&0===e.find("."+$.fn.appFormValidator.internal_options.field_wrapper_error_class).length&&$('a[href="#'+e.attr("id")+'"]').removeAttr("style").removeClass($.fn.appFormValidator.internal_options.validated_tab_class)}},jQuery.extend({highlight:function(t,e,n,i){if(3===t.nodeType){var o=t.data.match(e);if(o){var a=document.createElement(n||"span");a.className=i||"highlight";var r=t.splitText(o.index);r.splitText(o[0].length);var s=r.cloneNode(!0);return r.parentNode.tagName&&"textarea"!==r.parentNode.tagName.toLowerCase()&&(a.appendChild(s),r.parentNode.replaceChild(a,r)),1}}else if(1===t.nodeType&&t.childNodes&&!/(script|style)/i.test(t.tagName)&&(t.tagName!==n.toUpperCase()||t.className!==i))for(var l=0;l<t.childNodes.length;l++)l+=jQuery.highlight(t.childNodes[l],e,n,i);return 0}}),jQuery.fn.highlight=function(t,e){var n={className:"highlight animated flash",element:"span",caseSensitive:!1,wordsOnly:!1};if(jQuery.extend(n,e),t.constructor===String&&(t=[t]),t=jQuery.grep(t,(function(t,e){return""!=t})),0==(t=jQuery.map(t,(function(t,e){return t.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")}))).length)return this;var i=n.caseSensitive?"":"i",o="("+t.join("|")+")";n.wordsOnly&&(o="\\b"+o+"\\b");var a=new RegExp(o,i);return this.each((function(){jQuery.highlight(this,a,n.element,n.className)}))},jQuery.fn.unhighlight=function(t){var e={className:"highlight",element:"span"};return jQuery.extend(e,t),this.find(e.element+"."+e.className).each((function(){var t=this.parentNode;t.replaceChild(this.firstChild,this),t.normalize()})).end()},function(t){t.fn.googleDrivePicker=function(e){var n,i;function o(e){t(e).attr("data-picker-inited")||gapi.load("picker",(function(){t(e).attr("data-picker-inited",!0),e.disabled=!1,e.addEventListener("click",(function(){var e;i||(i=google.accounts.oauth2.initTokenClient({client_id:r.clientId,scope:r.scope,callback:""})),e=function(){var e=(new google.picker.DocsView).setIncludeFolders(!0),i=(new google.picker.DocsUploadView).setIncludeFolders(!0);r.mimeTypes&&(e.setMimeTypes(r.mimeTypes),i.setMimeTypes(r.mimeTypes)),(new google.picker.PickerBuilder).addView(e).addView(i).setOAuthToken(n).setDeveloperKey(r.developerKey).setCallback(a).build().setVisible(!0),setTimeout((function(){t(".picker-dialog").css("z-index",10002)}),20)},i.callback=async t=>{if(void 0!==t.error)throw t;n=t.access_token,e()},i.requestAccessToken({prompt:""})}))}))}function a(t){if(t[google.picker.Response.ACTION]==google.picker.Action.PICKED){var e=[];t[google.picker.Response.DOCUMENTS].forEach((function(t){e.push({name:t[google.picker.Document.NAME],link:t[google.picker.Document.URL],mime:t[google.picker.Document.MIME_TYPE]})})),"function"==typeof r.onPick?r.onPick(e):window[r.onPick](e)}}var r=t.extend({},t.fn.googleDrivePicker.defaults,e);return this.each((function(){r.clientId?(t(this).data("on-pick")&&(r.onPick=t(this).data("on-pick")),o(t(this)[0]),t(this).css("opacity",1)):t(this).css("opacity",0)}))}}(jQuery),$.fn.googleDrivePicker.defaults={scope:"https://www.googleapis.com/auth/drive",mimeTypes:null,developerKey:"",clientId:"",onPick:function(t){}},function(){"use strict";function t(i){if(!i)throw new Error("No options passed to Waypoint constructor");if(!i.element)throw new Error("No element option passed to Waypoint constructor");if(!i.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+e,this.options=t.Adapter.extend({},t.defaults,i),this.element=this.options.element,this.adapter=new t.Adapter(this.element),this.callback=i.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=t.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=t.Context.findOrCreateByElement(this.options.context),t.offsetAliases[this.options.offset]&&(this.options.offset=t.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),n[this.key]=this,e+=1}var e=0,n={};t.prototype.queueTrigger=function(t){this.group.queueTrigger(this,t)},t.prototype.trigger=function(t){this.enabled&&this.callback&&this.callback.apply(this,t)},t.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete n[this.key]},t.prototype.disable=function(){return this.enabled=!1,this},t.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},t.prototype.next=function(){return this.group.next(this)},t.prototype.previous=function(){return this.group.previous(this)},t.invokeAll=function(t){var e=[];for(var i in n)e.push(n[i]);for(var o=0,a=e.length;a>o;o++)e[o][t]()},t.destroyAll=function(){t.invokeAll("destroy")},t.disableAll=function(){t.invokeAll("disable")},t.enableAll=function(){for(var e in t.Context.refreshAll(),n)n[e].enabled=!0;return this},t.refreshAll=function(){t.Context.refreshAll()},t.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},t.viewportWidth=function(){return document.documentElement.clientWidth},t.adapters=[],t.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},t.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=t}(),function(){"use strict";function t(t){window.setTimeout(t,1e3/60)}function e(t){this.element=t,this.Adapter=o.Adapter,this.adapter=new this.Adapter(t),this.key="waypoint-context-"+n,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},t.waypointContextKey=this.key,i[t.waypointContextKey]=this,n+=1,o.windowContext||(o.windowContext=!0,o.windowContext=new e(window)),this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}var n=0,i={},o=window.Waypoint,a=window.onload;e.prototype.add=function(t){var e=t.options.horizontal?"horizontal":"vertical";this.waypoints[e][t.key]=t,this.refresh()},e.prototype.checkEmpty=function(){var t=this.Adapter.isEmptyObject(this.waypoints.horizontal),e=this.Adapter.isEmptyObject(this.waypoints.vertical),n=this.element==this.element.window;t&&e&&!n&&(this.adapter.off(".waypoints"),delete i[this.key])},e.prototype.createThrottledResizeHandler=function(){function t(){e.handleResize(),e.didResize=!1}var e=this;this.adapter.on("resize.waypoints",(function(){e.didResize||(e.didResize=!0,o.requestAnimationFrame(t))}))},e.prototype.createThrottledScrollHandler=function(){function t(){e.handleScroll(),e.didScroll=!1}var e=this;this.adapter.on("scroll.waypoints",(function(){(!e.didScroll||o.isTouch)&&(e.didScroll=!0,o.requestAnimationFrame(t))}))},e.prototype.handleResize=function(){o.Context.refreshAll()},e.prototype.handleScroll=function(){var t={},e={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var n in e){var i=e[n],o=i.newScroll>i.oldScroll?i.forward:i.backward;for(var a in this.waypoints[n]){var r=this.waypoints[n][a];if(null!==r.triggerPoint){var s=i.oldScroll<r.triggerPoint,l=i.newScroll>=r.triggerPoint;(s&&l||!s&&!l)&&(r.queueTrigger(o),t[r.group.id]=r.group)}}}for(var d in t)t[d].flushTriggers();this.oldScroll={x:e.horizontal.newScroll,y:e.vertical.newScroll}},e.prototype.innerHeight=function(){return this.element==this.element.window?o.viewportHeight():this.adapter.innerHeight()},e.prototype.remove=function(t){delete this.waypoints[t.axis][t.key],this.checkEmpty()},e.prototype.innerWidth=function(){return this.element==this.element.window?o.viewportWidth():this.adapter.innerWidth()},e.prototype.destroy=function(){var t=[];for(var e in this.waypoints)for(var n in this.waypoints[e])t.push(this.waypoints[e][n]);for(var i=0,o=t.length;o>i;i++)t[i].destroy()},e.prototype.refresh=function(){var t,e=this.element==this.element.window,n=e?void 0:this.adapter.offset(),i={};for(var a in this.handleScroll(),t={horizontal:{contextOffset:e?0:n.left,contextScroll:e?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:e?0:n.top,contextScroll:e?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}}){var r=t[a];for(var s in this.waypoints[a]){var l,d,p,c,u=this.waypoints[a][s],f=u.options.offset,h=u.triggerPoint,m=0,g=null==h;u.element!==u.element.window&&(m=u.adapter.offset()[r.offsetProp]),"function"==typeof f?f=f.apply(u):"string"==typeof f&&(f=parseFloat(f),u.options.offset.indexOf("%")>-1&&(f=Math.ceil(r.contextDimension*f/100))),l=r.contextScroll-r.contextOffset,u.triggerPoint=Math.floor(m+l-f),d=h<r.oldScroll,p=u.triggerPoint>=r.oldScroll,c=!d&&!p,!g&&(d&&p)?(u.queueTrigger(r.backward),i[u.group.id]=u.group):(!g&&c||g&&r.oldScroll>=u.triggerPoint)&&(u.queueTrigger(r.forward),i[u.group.id]=u.group)}}return o.requestAnimationFrame((function(){for(var t in i)i[t].flushTriggers()})),this},e.findOrCreateByElement=function(t){return e.findByElement(t)||new e(t)},e.refreshAll=function(){for(var t in i)i[t].refresh()},e.findByElement=function(t){return i[t.waypointContextKey]},window.onload=function(){a&&a(),e.refreshAll()},o.requestAnimationFrame=function(e){(window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||t).call(window,e)},o.Context=e}(),function(){"use strict";function t(t,e){return t.triggerPoint-e.triggerPoint}function e(t,e){return e.triggerPoint-t.triggerPoint}function n(t){this.name=t.name,this.axis=t.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),i[this.axis][this.name]=this}var i={vertical:{},horizontal:{}},o=window.Waypoint;n.prototype.add=function(t){this.waypoints.push(t)},n.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},n.prototype.flushTriggers=function(){for(var n in this.triggerQueues){var i=this.triggerQueues[n],o="up"===n||"left"===n;i.sort(o?e:t);for(var a=0,r=i.length;r>a;a+=1){var s=i[a];(s.options.continuous||a===i.length-1)&&s.trigger([n])}}this.clearTriggerQueues()},n.prototype.next=function(e){this.waypoints.sort(t);var n=o.Adapter.inArray(e,this.waypoints);return n===this.waypoints.length-1?null:this.waypoints[n+1]},n.prototype.previous=function(e){this.waypoints.sort(t);var n=o.Adapter.inArray(e,this.waypoints);return n?this.waypoints[n-1]:null},n.prototype.queueTrigger=function(t,e){this.triggerQueues[e].push(t)},n.prototype.remove=function(t){var e=o.Adapter.inArray(t,this.waypoints);e>-1&&this.waypoints.splice(e,1)},n.prototype.first=function(){return this.waypoints[0]},n.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},n.findOrCreate=function(t){return i[t.axis][t.name]||new n(t)},o.Group=n}(),function(){"use strict";function t(t){this.$element=e(t)}var e=window.jQuery,n=window.Waypoint;e.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],(function(e,n){t.prototype[n]=function(){var t=Array.prototype.slice.call(arguments);return this.$element[n].apply(this.$element,t)}})),e.each(["extend","inArray","isEmptyObject"],(function(n,i){t[i]=e[i]})),n.adapters.push({name:"jquery",Adapter:t}),n.Adapter=t}(),function(){"use strict";function t(t){return function(){var n=[],i=arguments[0];return t.isFunction(arguments[0])&&((i=t.extend({},arguments[1])).handler=arguments[0]),this.each((function(){var o=t.extend({},i,{element:this});"string"==typeof o.context&&(o.context=t(this).closest(o.context)[0]),n.push(new e(o))})),n}}var e=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=t(window.jQuery)),window.Zepto&&(window.Zepto.fn.waypoint=t(window.Zepto))}(),function(t){var e;jQuery,e="smartresize",jQuery.fn[e]=function(t){return t?this.on("resize",(n=t,function(){var t=this,e=arguments;a?clearTimeout(a):o&&n.apply(t,e),a=setTimeout((function(){o||n.apply(t,e),a=null}),i||100)})):this.trigger(e);var n,i,o,a},t.fn.isOnScreen=function(e,n){null!=e&&void 0!==e||(e=1),null!=n&&void 0!==n||(n=1);var i=t(window),o={top:i.scrollTop(),left:i.scrollLeft()};o.right=o.left+i.width(),o.bottom=o.top+i.height();var a=this.outerHeight(),r=this.outerWidth();if(!r||!a)return!1;var s=this.offset();if(s.right=s.left+r,s.bottom=s.top+a,!!(o.right<s.left||o.left>s.right||o.bottom<s.top||o.top>s.bottom))return!1;var l=Math.min(1,(s.bottom-o.top)/a),d=Math.min(1,(o.bottom-s.top)/a);return Math.min(1,(s.right-o.left)/r)*Math.min(1,(o.right-s.left)/r)>=e&&l*d>=n},t.fn.horizontalTabs=function(){return this.each((function(){var e,n=t(this),i={getArrowsTotalWidth:function(){return n.find(".arrow-left").outerWidth()+n.find(".arrow-right").outerWidth()},adjustScroll:function(){var o;r=0,n.find(".nav-tabs-horizontal li:not(.nav-tabs-submenu-child, nav-tabs-submenu-parent)").each((function(i,a){r+=t(a).outerWidth(),t(a).hasClass("active")&&r>n.width()&&(o=t(a)),t(a).is(":last-child")&&(e=t(a))})),widthAvailale=n.width(),r>widthAvailale?(n.find(".scroller").show(),i.updateArrowStyle(s),a=n.find(".nav-tabs-horizontal").outerWidth()):n.find(".scroller").hide(),o&&setTimeout((function(){s=o.position().left-i.getArrowsTotalWidth(),n.find(".nav-tabs-horizontal").animate({scrollLeft:s},100)}),150)},scrollLeft:function(){n.find(".nav-tabs-horizontal").animate({scrollLeft:s-a},500),s-a>0?s-=a:s=0},scrollRight:function(){n.find(".nav-tabs-horizontal").animate({scrollLeft:s+a},500),s+a<r-a?s+=a:s=r-a},manualScroll:function(){s=n.find(".nav-tabs-horizontal").scrollLeft(),i.updateArrowStyle(s)},updateArrowStyle:function(t){new Waypoint({element:e[0],context:n[0],horizontal:!0,offset:"right-in-view",handler:function(t){delay((function(){"right"==t&&e.isOnScreen()?n.find(".arrow-right").addClass("disabled"):n.find(".arrow-right").removeClass("disabled")}),200)}}),t<=0?(n.find(".arrow-left").addClass("disabled"),setTimeout((function(){n.find(".arrow-right").removeClass("disabled")}),100)):n.find(".arrow-left").removeClass("disabled")},clearMenuItem:function(e){t('[data-sub-menu-id="'+e.attr("data-menu-id")+'"]').remove(),e.removeAttr("data-menu-id")},genUniqueID:function(){return Math.random().toString(36).substr(2,9)}},o=n.find("li.nav-tabs-submenu-parent > a"),a=n.find(".nav-tabs-horizontal").outerWidth(),r=0,s=0;return t(window).smartresize((function(){i.adjustScroll()})),o.length>0&&o.on("click",(function(e){e.preventDefault();var n=t(this);if(n.attr("data-menu-id"))return i.clearMenuItem(n),!1;var o=i.genUniqueID();n.attr("data-menu-id",o);var a=n.parents("li.nav-tabs-submenu-parent").find(".tabs-submenu-wrapper").clone(),r=n.offset();a.find("ul").css({top:r.top+n.outerHeight()-5,left:r.left,display:"block","border-top-left-radius":"0","border-top-right-radius":"0"}).attr("data-sub-menu-id",o),a.find("ul li.active:eq(0) > a").css({"border-top-left-radius":"0","border-top-right-radius":"0"}),t("body").append(a.unwrap().html()),t("body").on("click",(function(t){t.target!=n[0]&&i.clearMenuItem(n)}))})),n.find(".arrow-left").on("click.horizontalTabs",(function(){if(t(this).hasClass("disabled"))return!1;i.scrollLeft()})),n.find(".arrow-right").on("click.horizontalTabs",(function(){if(t(this).hasClass("disabled"))return!1;i.scrollRight()})),n.find(".nav-tabs-horizontal").scroll((function(){i.manualScroll()})),i.adjustScroll(),this}))}}(window.jQuery),$(document).keyup((function(t){27==t.keyCode&&$(".modal").is(":visible")&&1===$(".modal:visible").length&&$("body").find('.modal:visible [onclick^="close_modal_manually"]').eq(0).click()})),$((function(){setTimeout((function(){$("#gantt .noDrag > g.handle-group").hide();var t=document.querySelectorAll(".bar-wrapper");Array.prototype.forEach.call(t,(function(t){t.addEventListener("mousedown",(function(t,e){$(t.target).closest(".bar-wrapper").hasClass("noDrag")&&event.stopPropagation()}),!0)}))}),1e3);var t=1;$("body").on("click",".add_more_attachments",(function(){if($(this).hasClass("disabled"))return!1;var e=$('.attachments input[name*="attachments"]').length;if($(this).data("max")&&e>=$(this).data("max"))return!1;var n=$(".attachments").find(".attachment").eq(0).clone().appendTo(".attachments");n.find("input").removeAttr("aria-describedby aria-invalid"),n.find("input").attr("name","attachments["+t+"]").val(""),n.find($.fn.appFormValidator.internal_options.error_element+'[id*="error"]').remove(),n.find("."+$.fn.appFormValidator.internal_options.field_wrapper_class).removeClass($.fn.appFormValidator.internal_options.field_wrapper_error_class),n.find("i").removeClass("fa-plus").addClass("fa-minus"),n.find("button").removeClass("add_more_attachments").addClass("remove_attachment").removeClass("btn-success").removeClass("btn-default").addClass("btn-danger"),t++})),$("body").on("click",".remove_attachment",(function(){$(this).parents(".attachment").remove()})),$("a[href='#top']").on("click",(function(t){t.preventDefault(),$("html,body").animate({scrollTop:0},1e3),t.preventDefault()})),$("a[href='#bot']").on("click",(function(t){t.preventDefault(),$("html,body").animate({scrollTop:$(document).height()},1e3),t.preventDefault()})),$(document).on("change",".dt-page-jump-select",(function(){$("#"+$(this).attr("data-id")).DataTable().page($(this).val()-1).draw(!1)})),$("body").on("click",(function(){$(".tooltip").remove()})),$("body").on("click","[data-loading-text]",(function(){var t=$(this).data("form");if(null!=t)return!0;$(this).button("loading")})),$("body").on("click",(function(t){$('[data-toggle="popover"],.manual-popover').each((function(){$(this).is(t.target)||0!==$(this).has(t.target).length||0!==$(".popover").has(t.target).length||$(this).popover("hide")}))})),$("body").on("change",'select[name="range"]',(function(){var t=$(".period");"period"==$(this).val()?t.removeClass("hide"):(t.addClass("hide"),t.find("input").val(""))})),$(document).on("shown.bs.dropdown",".table-responsive",(function(t){var e=$(t.target);if(!e.hasClass("bootstrap-select")){var n=e.find(".dropdown-menu");n.length?e.data("dropdown-menu",n):n=e.data("dropdown-menu"),n.css("top",e.offset().top+e.outerHeight()+"px");var i;n.css("display","block"),n.css("position","absolute");var o=e.parent().outerWidth(),a=n.outerWidth();i=e.parent().offset().left-(a-o),n.css("left",i+"px"),n.css("right","auto"),n.appendTo("body")}})),$(document).on("hide.bs.dropdown",".table-responsive",(function(t){var e=$(t.target);e.hasClass("bootstrap-select")||e.data("dropdown-menu").css("display","none")})),$("body").on("click","._delete",(function(t){return!!confirm_delete()}))}));var delay=function(){var t=0;return function(e,n){clearTimeout(t),t=setTimeout(e,n)}}();function slugify(t){return t.toString().trim().toLowerCase().replace(/\s+/g,"-").replace(/[^\w\-]+/g,"").replace(/\-\-+/g,"-").replace(/^-+/,"").replace(/-+$/,"")}function stripTags(t){var e=document.createElement("DIV");return e.innerHTML=t,e.textContent||e.innerText||""}function empty(t){if("number"==typeof t||"boolean"==typeof t)return!1;if(null==t)return!0;if(void 0!==t.length)return 0===t.length;var e=0;for(var n in t)t.hasOwnProperty(n)&&e++;return 0===e}function add_hotkey(t,e){if(void 0===$.Shortcuts)return!1;$.Shortcuts.add({type:"down",mask:t,handler:e})}function decimalToHM(t){var e=parseInt(Number(t)),n=Math.round(60*(Number(t)-e));return(e<10?"0"+e:e)+":"+(n<10?"0"+n:n)}function color(t,e,n){return"rgb("+t+","+e+","+n+")"}function buildUrl(t,e){var n="";for(var i in e){var o=e[i];n+=encodeURIComponent(i)+"="+encodeURIComponent(o)+"&"}return n.length>0&&(t=t+"?"+(n=n.substring(0,n.length-1))),t}function is_ios(){return/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream}function is_ms_browser(){return!(!/MSIE/i.test(navigator.userAgent)&&!navigator.userAgent.match(/Trident.*rv\:11\./))||!!/Edge/i.test(navigator.userAgent)}function _simple_editor_config(){return{forced_root_block:"p",menubar:!1,autoresize_bottom_margin:15,plugins:["quickbars","table","advlist","codesample","autosave","lists","link","image","media"],toolbar:"blocks image media alignleft aligncenter alignright bullist numlist restoredraft",quickbars_insert_toolbar:"image quicktable | hr",quickbars_selection_toolbar:"bold italic | forecolor backcolor | quicklink | h2 h3 | codesample"}}function _create_print_window(t){var e="width="+screen.width;return e+=", height="+screen.height,e+=", top=0, left=0",e+=", fullscreen=yes",window.open("",t,e)}function _add_print_window_default_styles(t){t.document.write("<style>"),t.document.write('.clearfix:after { clear: both;}.clearfix:before, .clearfix:after { display: table; content: " ";}body { font-family: Arial, Helvetica, sans-serif;color: #444; font-size:13px;}.bold { font-weight: bold !important;}'),t.document.write("</style>")}function nl2br(t,e){return(t+"").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1"+(e||void 0===e?"<br />":"<br>")+"$2")}function tilt_direction(t){setTimeout((function(){var e=t.position().left,n=function(n){n.pageX>=e?(t.addClass("right"),t.removeClass("left")):(t.addClass("left"),t.removeClass("right")),e=n.pageX};$("html").on("mousemove",n),t.data("move_handler",n)}),1e3)}function close_modal_manually(t){(t=0===$(t).length?$("body").find(t):t=$(t)).fadeOut("fast",(function(){t.remove(),$("body").find(".modal").is(":visible")||($(".modal-backdrop").remove(),$("body").removeClass("modal-open"))}))}function showPassword(t){var e=$('input[name="'+t+'"]');"password"==$(e).attr("type")&&""!==$(e).val()?$(e).queue((function(){$(e).attr("type","text").dequeue()})):$(e).queue((function(){$(e).attr("type","password").dequeue()}))}function hidden_input(t,e){return'<input type="hidden" name="'+t+'" value="'+e+'">'}function appColorPicker(t){void 0===t&&(t=$("body").find("div.colorpicker-input")),t.length&&t.colorpicker({format:"hex"})}function appSelectPicker(t){void 0===t&&(t=$("body").find("select.selectpicker")),t.length&&t.selectpicker({showSubtext:!0})}function appProgressBar(){var t=$("body").find(".progress div.progress-bar");t.length&&t.each((function(){var t=$(this),e=t.attr("data-percent");t.css("width",e+"%"),t.hasClass("no-percent-text")||t.text(e+"%")}))}function appLightbox(t){if("undefined"==typeof lightbox)return!1;var e={showImageNumberLabel:!1,resizeDuration:200,positionFromTop:25};void 0!==t&&jQuery.extend(e,t),lightbox.option(e)}function DataTablesInlineLazyLoadImages(t,e,n){var i=$("img.img-table-loading",t);return i.attr("src",i.data("orig")),i.prev("div").addClass("hide"),t}function _table_jump_to_page(t,e){var n=t.DataTable().page.info(),i=$("body").find("#dt-page-jump-"+e.sTableId);if(i.length&&i.remove(),n.pages>1){for(var o=$("<select></select>",{"data-id":e.sTableId,class:"dt-page-jump-select form-control",id:"dt-page-jump-"+e.sTableId}),a="",r=1;r<=n.pages;r++){a+="<option value='"+r+"'"+(n.page+1===r?"selected":"")+">"+r+"</option>"}""!=a&&o.append(a),$("#"+e.sTableId+"_wrapper .dt-page-jump").append(o)}}function alert_float(t,e,n){var i,o;i=$("body").find("float-alert").length,i="alert_float_"+ ++i,(o=$("<div></div>",{id:i,class:"float-alert animated fadeInRight col-xs-10 col-sm-3 alert alert-"+t})).append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'),o.append('<span class="fa-regular fa-bell" data-notify="icon"></span>'),o.append('<span class="alert-title">'+e+"</span>"),$("body").append(o),n=n||3500,setTimeout((function(){$("#"+i).hide("fast",(function(){$("#"+i).remove()}))}),n)}function generatePassword(t){for(var e="abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",n="",i=0;i<12;++i)n+=e.charAt(Math.floor(61*Math.random()));$(t).parents().find("input.password").val(n)}function get_url_param(t){var e={};return window.location.href.replace(location.hash,"").replace(/[?&]+([^=&]+)=?([^&]*)?/gi,(function(t,n,i){e[n]=void 0!==i?i:""})),t?e[t]?e[t]:null:e}function is_mobile(){if("undefined"!=typeof app&&void 0!==app.is_mobile)return app.is_mobile;try{return document.createEvent("TouchEvent"),!0}catch(t){return!1}}function onGoogleApiLoad(){var t=$(".gpicker");$.each(t,(function(){var t=$(this);setTimeout((function(){t.googleDrivePicker()}),10)}))}function _get_jquery_comments_default_config(t){return{roundProfilePictures:!0,textareaRows:4,textareaRowsOnFocus:6,profilePictureURL:discussion_user_profile_image_url,enableUpvoting:!1,enableDeletingCommentWithReplies:!1,enableAttachments:!0,popularText:"",enableDeleting:!0,textareaPlaceholderText:t.discussion_add_comment,newestText:t.discussion_newest,oldestText:t.discussion_oldest,attachmentsText:t.discussion_attachments,sendText:t.discussion_send,replyText:t.discussion_reply,editText:t.discussion_edit,editedText:t.discussion_edited,youText:t.discussion_you,saveText:t.discussion_save,deleteText:t.discussion_delete,viewAllRepliesText:t.discussion_view_all_replies+" (__replyCount__)",hideRepliesText:t.discussion_hide_replies,noCommentsText:t.discussion_no_comments,noAttachmentsText:t.discussion_no_attachments,attachmentDropText:t.discussion_attachments_drop,timeFormatter:function(t){return moment(t).fromNow()}}}

function appDataTableInline(t, e) {
    var n = $(void 0 !== t ? t : ".dt-table");
    if (0 !== n.length) {
        var i, o, a, r = {
            supportsButtons: !1,
            supportsLoading: !1,
            dtLengthMenuAllText: app.lang.dt_length_menu_all,
            processing: !0,
            language: app.lang.datatables,
            paginate: !0,
            pageLength: app.options.tables_pagination_limit,
            fnRowCallback: DataTablesInlineLazyLoadImages,
            order: [0, "asc"],
            dom: "<'row'><'row'<'col-md-6'lB><'col-md-6'f>r>t<'row'<'col-md-4'i><'col-md-8 dataTables_paging'<'#colvis'><'.dt-page-jump'>p>>",
            fnDrawCallback: function (t) {
                _table_jump_to_page(this, t);
                if (0 == t.aoData.length || 0 == t.aiDisplay.length) {
                    $(t.nTableWrapper).addClass("app_dt_empty");
                } else {
                    $(t.nTableWrapper).removeClass("app_dt_empty");
                }
                if ("function" == typeof s.onDrawCallback) {
                    s.onDrawCallback(t, this);
                }
            },
            initComplete: function (t, e) {
                this.wrap('<div class="table-responsive"></div>');
                var i = this.find(".dataTables_empty");
                if (i.length) {
                    i.attr("colspan", this.find("thead th").length);
                }
                if (s.supportsLoading) {
                    this.parents(".table-loading").removeClass("table-loading");
                }
                if (s.supportsButtons) {
                    var lastHeader = n.find("thead th:last-child");
                    if (lastHeader.hasClass("options")) {
                        lastHeader.addClass("not-export");
                    }
                    var lastHeader = n.find("thead th:last-child");
                    if ("undefined" != typeof app && lastHeader.text().trim() == app.lang.options) {
                        lastHeader.addClass("not-export");
                    }
                    var firstHeader = n.find("thead th:first-child");
                    if (firstHeader.find('input[type="checkbox"]').length > 0) {
                        firstHeader.addClass("not-export");
                    }
                }
                if ("function" == typeof s.onInitComplete) {
                    s.onInitComplete(t, e, this);
                }
            },
            buttons: get_datatable_buttons()
        };

        s = $.extend({}, r, e);

        var l = [10, 25, 50, 100],
            d = [10, 25, 50, 100];
        s.pageLength = parseFloat(s.pageLength);
        if (-1 == $.inArray(s.pageLength, l)) {
            l.push(s.pageLength);
            d.push(s.pageLength);
        }
        l.sort(function (t, e) {
            return t - e;
        });
        d.sort(function (t, e) {
            return t - e;
        });
        l.push(-1);
        d.push(s.dtLengthMenuAllText);
        s.lengthMenu = [l, d];
        if (!s.supportsButtons) {
            s.dom = s.dom.replace("lB", "l");
        }
        $.each(n, function () {
            $(this).addClass("dt-inline");
            i = $(this).attr("data-order-col");
            o = $(this).attr("data-order-type");
            a = $(this).attr("data-s-type");
            if (i && o) {
                s.order = [[i, o]];
            }
            if (a) {
                a = JSON.parse(a);
                var t = $(this).find("thead th"),
                    e = t.length;
                s.aoColumns = [];
                for (var n = 0; n < e; n++) {
                    var r = $(t[n]),
                        l = a.find(function (t) {
                            return t.column === r.index();
                        });
                    s.aoColumns.push(l ? { sType: l.type } : null);
                }
            }
            if (s.supportsButtons) {
                s.buttons = get_datatable_buttons(this);
            }
            $(this).DataTable(s);
        });
    }
}

function get_datatable_buttons(t) {
    if (("persian" == app.user_language.toLowerCase() || "arabic" == app.user_language.toLowerCase()) && 0 === $("body").find("#amiri").length) {
        var e = document.createElement("script");
        e.setAttribute("src", "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.js"),
            e.setAttribute("id", "amiri"),
            document.head.appendChild(e);
        var n = document.createElement("script");
        n.setAttribute("src", "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.map.js"),
            document.head.appendChild(n);
    }
    var o = {
        body: function (t, e, n, i) {
            var o = $("<div></div>", t);
            o.append(t), o.find("[data-note-edit-textarea]").length > 0 && (o.find("[data-note-edit-textarea]").remove(), t = o.html().trim());
            var a = o.find(".text-has-action.is-date");
            a.length && (t = a.attr("data-title")),
                o.find(".row-options").length > 0 && (o.find(".row-options").remove(), t = o.html().trim()),
                o.find(".table-export-exclude").length > 0 && (o.find(".table-export-exclude").remove(), t = o.html().trim());
            var r = document.createElement("div");
            return r.innerHTML = t, (r.textContent || r.innerText || "").trim();
        }
    },
        a = [];
    "function" == typeof table_export_button_is_hidden && table_export_button_is_hidden() || a.push({
        extend: "collection",
        text: app.lang.dt_button_export,
        className: "btn btn-sm btn-default-dt-options",
        buttons: [{
            extend: "excel",
            text: app.lang.dt_button_excel,
            footer: !0,
            exportOptions: {
                columns: [":not(.not-export)"],
                rows: function (e) {
                    return _dt_maybe_export_only_selected_rows(e, t);
                },
                format: {
					body: function (data, row, column, node) {
						var $node = $(node);
						
						// Handle <select> elements
						if ($node.is('select')) {
							return $node.find('option:selected').text();
						} else if ($node.find('select').length > 0) {
							return $node.find('select option:selected').text();
						}
						
						// Handle text nodes and exclude "Edit" text
						var text = $node.text().trim();
						
						// Find and exclude "Edit" text
						var excludedText = $node.find('a[target="_blank"]').text().trim();
						if (excludedText === "Edit") {
							text = text.replace(excludedText, "").trim();
						}
						
						return text;
					}
				}
            }
        }, {
            extend: "csvHtml5",
            text: app.lang.dt_button_csv,
            footer: !0,
            exportOptions: {
                columns: [":not(.not-export)"],
                rows: function (e) {
                    return _dt_maybe_export_only_selected_rows(e, t);
                },
                format: {
					body: function (data, row, column, node) {
						var $node = $(node);
						
						// Handle <select> elements
						if ($node.is('select')) {
							return $node.find('option:selected').text();
						} else if ($node.find('select').length > 0) {
							return $node.find('select option:selected').text();
						}
						
						// Handle text nodes and exclude "Edit" text
						var text = $node.text().trim();
						
						// Find and exclude "Edit" text
						var excludedText = $node.find('a[target="_blank"]').text().trim();
						if (excludedText === "Edit") {
							text = text.replace(excludedText, "").trim();
						}
						
						return text;
					}
				}
            }
        }, {
            extend: "pdfHtml5",
            text: app.lang.dt_button_pdf,
            footer: !0,
            exportOptions: {
                columns: [":not(.not-export)"],
                rows: function (e) {
                    return _dt_maybe_export_only_selected_rows(e, t);
                },
                format: {
					body: function (data, row, column, node) {
						var $node = $(node);
						
						// Handle <select> elements
						if ($node.is('select')) {
							return $node.find('option:selected').text();
						} else if ($node.find('select').length > 0) {
							return $node.find('select option:selected').text();
						}
						
						// Handle text nodes and exclude "Edit" text
						var text = $node.text().trim();
						
						// Find and exclude "Edit" text
						var excludedText = $node.find('a[target="_blank"]').text().trim();
						if (excludedText === "Edit") {
							text = text.replace(excludedText, "").trim();
						}
						
						return text;
					}
				}
            },
            orientation: "landscape",
            customize: function (e) {
                var n = $(t).DataTable().columns().visible(),
                    o = n.length,
                    a = 0;
                for (i = 0; i < o; i++) 1 == n[i] && a++;
                setTimeout(function () {
                    if (a <= 5) {
                        var t = [];
                        for (i = 0; i < a; i++) t.push(735 / a);
                        e.content[1].table.widths = t;
                    }
                }, 10),
                    "persian" != app.user_language.toLowerCase() && "arabic" != app.user_language.toLowerCase() || (e.defaultStyle.font = Object.keys(pdfMake.fonts)[0]),
                    e.styles.tableHeader.alignment = "left",
                    e.defaultStyle.fontSize = 10,
                    e.styles.tableHeader.fontSize = 10,
                    e.styles.tableFooter.fontSize = 10,
                    e.styles.tableFooter.alignment = "left";
            }
        },{
        extend: "print",
        text: app.lang.dt_button_print,
        footer: !0,
        exportOptions: {
            columns: [":not(.not-export)"],
            rows: function (e) {
                return _dt_maybe_export_only_selected_rows(e, t);
            },
            format: {
				body: function (data, row, column, node) {
					var $node = $(node);
					
					// Handle <select> elements
					if ($node.is('select')) {
						return $node.find('option:selected').text();
					} else if ($node.find('select').length > 0) {
						return $node.find('select option:selected').text();
					}
					
					// Handle text nodes and exclude "Edit" text
					var text = $node.text().trim();
					
					// Find and exclude "Edit" text
					var excludedText = $node.find('a[target="_blank"]').text().trim();
					if (excludedText === "Edit") {
						text = text.replace(excludedText, "").trim();
					}
					
					return text;
				}
			}
        }
    }]})
    return a;
}

function table_export_button_is_hidden(){return"to_all"!=app.options.show_table_export_button&&("hide"===app.options.show_table_export_button||"only_admins"===app.options.show_table_export_button&&0==app.user_is_admin)}function _dt_maybe_export_only_selected_rows(t,e){e=$(e),t=t.toString();var n=e.find('thead th input[type="checkbox"]').eq(0);if(n&&n.length>0){var i=e.find("tbody tr"),o=!1;return $.each(i,(function(){$(this).find('td:first input[type="checkbox"]:checked').length&&(o=!0)})),o?e.find("tbody tr:eq("+t+') td:first input[type="checkbox"]:checked').length>0?t:null:t}return t}function slideToggle(t,e){var n=$(t);n.hasClass("hide")&&n.removeClass("hide","slow"),n.length&&n.slideToggle();var i=$(".progress-bar").not(".not-dynamic");i.length>0&&(i.each((function(){$(this).css("width","0%"),$(this).text("0%")})),"function"==typeof appProgressBar&&appProgressBar()),"function"==typeof e&&e()}function appDatepicker(t){void 0===app._date_picker_locale_configured&&(jQuery.datetimepicker.setLocale(app.locale),app._date_picker_locale_configured=!0);var e={date_format:app.options.date_format,time_format:app.options.time_format,week_start:app.options.calendar_first_day,date_picker_selector:".datepicker",date_time_picker_selector:".datetimepicker"},n=$.extend({},e,t),i=void 0!==n.element_date?n.element_date:$(n.date_picker_selector),o=void 0!==n.element_time?n.element_time:$(n.date_time_picker_selector);0===o.length&&0===i.length||($.each(i,(function(){var t=$(this),e={timepicker:!1,scrollInput:!1,lazyInit:!0,format:n.date_format,dayOfWeekStart:n.week_start},i=t.attr("data-date-end-date"),o=t.attr("data-date-min-date"),a=t.attr("data-lazy");a&&(e.lazyInit="true"==a),i&&(e.maxDate=i),o&&(e.minDate=o),t.datetimepicker(e),t.parents(".form-group").find(".calendar-icon").on("click",(function(){t.focus(),t.trigger("open.xdsoft")}))})),$.each(o,(function(){var t=$(this),e={lazyInit:!0,scrollInput:!1,validateOnBlur:!1,dayOfWeekStart:n.week_start};24==n.time_format?e.format=n.date_format+" H:i":(e.format=n.date_format+" g:i A",e.formatTime="g:i A");var i=t.attr("data-date-end-date"),o=t.attr("data-date-min-date"),a=t.attr("data-step"),r=t.attr("data-lazy");r&&(e.lazyInit="true"==r),a&&(e.step=parseInt(a)),i&&(e.maxDate=i),o&&(e.minDate=o),t.datetimepicker(e),t.parents(".form-group").find(".calendar-icon").on("click",(function(){t.focus(),t.trigger("open.xdsoft")}))})))}function appTagsInput(t){void 0===t&&(t=$("body").find("input.tagsinput")),t.length&&t.tagit({availableTags:app.available_tags,allowSpaces:!0,animate:!1,placeholderText:app.lang.tag,showAutocompleteOnFocus:!0,caseSensitive:!1,autocomplete:{appendTo:"#inputTagsWrapper"},afterTagAdded:function(t,e){var n=app.available_tags.indexOf($.trim($(e.tag).find(".tagit-label").text()));if(n>-1){var i=app.available_tags_ids[n];$(e.tag).addClass("tag-id-"+i)}showHideTagsPlaceholder($(this))},afterTagRemoved:function(t,e){showHideTagsPlaceholder($(this))}})}function fixHelperTableHelperSortable(t,e){return e.children().each((function(){$(this).width($(this).width())})),e}function _dropzone_defaults(){var t=app.options.allowed_files;return"safari"===app.browser&&t.indexOf(".jpg")>-1&&-1===t.indexOf(".jpeg")&&(t+=",.jpeg"),{createImageThumbnails:!0,dictDefaultMessage:app.lang.drop_files_here_to_upload,dictFallbackMessage:app.lang.browser_not_support_drag_and_drop,dictFileTooBig:app.lang.file_exceeds_maxfile_size_in_form,dictCancelUpload:app.lang.cancel_upload,dictRemoveFile:app.lang.remove_file,dictMaxFilesExceeded:app.lang.you_can_not_upload_any_more_files,maxFilesize:(app.max_php_ini_upload_size_bytes/1048576).toFixed(0),acceptedFiles:t,error:function(t,e){alert_float("danger",e)},complete:function(t){this.files.length&&this.removeFile(t)}}}function appCreateDropzoneOptions(t){return $.extend({},_dropzone_defaults(),t)}function onChartClickRedirect(t,e,n){void 0===n&&(n="statusLink");var i=e.getElementAtEvent(t)[0];if(i){var o=e.data.datasets[0][n][i._index];o&&(window.location.href=o)}}function destroy_dynamic_scripts_in_element(t){t.find("input.tagsinput").tagit("destroy").find(".manual-popover").popover("destroy").find(".datepicker").datetimepicker("destroy").find("select").selectpicker("destroy")}function appValidateForm(t,e,n,i){$(t).appFormValidator({rules:e,onSubmit:n,messages:i})}function htmlEntities(t){return String(t).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;")}function escapeHtml(t,e=!0){if(null==t)return"";"object"==typeof t&&t.hasOwnProperty("value")&&(t=t.value);let n=t.toString().replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;");return e||(n=n.replace(/&amp;(#\d+;|#[xX][\da-fA-F]+;|[a-zA-Z]+;)/g,"&$1")),n}function init_tinymce_inline_editor(t={},e){function n(e){t.saveUsing&&t.saveUsing(e)}e=e||"div.editable",tinymce.remove(e);var i={selector:e,inline:!0,toolbar:!1,menubar:!1,branding:!1,cache_suffix:"?v="+app.version,language:app.tinymce_lang||"en",relative_urls:!1,remove_script_host:!1,paste_block_drop:!0,entity_encoding:"raw",apply_source_formatting:!1,valid_elements:"+*[*]",valid_children:"+body[style], +style[type]",file_picker_callback:elFinderBrowser,table_default_styles:{width:"100%"},font_size_formats:"8pt 10pt 12pt 14pt 18pt 24pt 36pt",pagebreak_separator:'<p pagebreak="true"></p>',pagebreak_split_block:!0,plugins:["quickbars","advlist","autolink","lists","link","image","visualblocks","code","pagebreak","searchreplace","media","table"],autoresize_bottom_margin:50,quickbars_insert_toolbar:"image media quicktable | bullist numlist | h2 h3 | pagebreak | hr",quickbars_selection_toolbar:"bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontfamily fontsize | h2 h3",contextmenu:"paste pastetext searchreplace | visualblocks pagebreak | code",setup:function(e){t.onSetup&&t.onSetup(e),e.addCommand("mceSave",(function(){n(!0)})),e.addShortcut("Meta+S","","mceSave"),e.on("MouseLeave blur",(function(){tinymce.activeEditor.isDirty()&&n()})),e.on("blur",(function(){$.Shortcuts.start()})),e.on("focus",(function(){$.Shortcuts.stop()}))}};is_mobile()&&window.addEventListener("beforeunload",(function(t){tinymce.activeEditor.isDirty()&&n()})),tinymce.init(i)}function _tinymce_mobile_toolbar(){return["undo","redo","styleselect","bold","italic","link","image","bullist","numlist","forecolor","fontsizeselect"]}$.fn.isInViewport=function(){var t=$(this).offset().top,e=t+$(this).outerHeight(),n=$(window).scrollTop(),i=n+$(window).height();return e>n&&t<i},String.prototype.matchAll=function(t){var e=[];return this.replace(t,(function(){var t=[].slice.call(arguments,0),n=t.splice(-2);t.index=n[0],t.input=n[1],e.push(t)})),e.length?e:null};
