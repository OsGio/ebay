/**
 * jQuery.bottom
 * Dual licensed under MIT and GPL.
 * Date: 2010-04-25
 *
 * @description Trigger the bottom event when the user has scrolled to the bottom of an element
 * @author Jim Yi
 * @version 1.0
 *
 * @id jQuery.fn.bottom
 * @param {Object} settings Hash of settings.
 * @return {jQuery} Returns the same jQuery object for chaining.
 *
 */
(function(e){e.fn.bottom=function(t){var n={proximity:0};var t=e.extend(n,t);return this.each(function(){var n=this;e(n).bind("scroll",function(){if(n==window){scrollHeight=e(document).height()}else{scrollHeight=e(n)[0].scrollHeight}scrollPosition=e(n).height()+e(n).scrollTop();if((scrollHeight-scrollPosition)/scrollHeight<=t.proximity){e(n).trigger("bottom")}});return false})}})(jQuery)