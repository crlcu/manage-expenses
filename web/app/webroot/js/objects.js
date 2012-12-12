var Login = (function () {
    "use strict";
    
    function Login(){
        var screenX        = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
        screenY        = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
        outerWidth     = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
        outerHeight    = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
        width          = 500,
        height     = 500,
        left       = parseInt(screenX + ((outerWidth - width) / 2), 10),
        top        = parseInt(screenY + ((outerHeight - height) / 2.5), 10);
        
        this.features   = (
            'width=' + width +
            ',height=' + height +
            ',left=' + left +
            ',top=' + top+
            ',scrollbars=yes'
        );
    }
    
    Login.prototype.facebook = function ( url ) {
        var newwindow = window.open(url, '', this.features);
        
        if ( window.focus ) {
            newwindow.focus()
        }
        
        return false;
    }
    
    return Login;
})();

var Table = (function () {
    "use strict";
    
    function Table( options ){
        var table = this;
        
        var defaults = {
            table : $(''),
            editTemplate: ''
        };
        
        this.options = $.extend(defaults, options);
        
        options.table.on('dblclick', 'tr.edit td', function(e){
            table.edit( $(this).parent('tr') );
        });
    }
    
    Table.prototype.template = function ( args ) {
        return _.template(this.options.editTemplate, args) ;
    }
    
    Table.prototype.edit = function( $row ){
        $row.hide();
        
        var $edit = $(this.template({description: 'descr', setting: 'set', value: 'val', plugin: 'plugin', controller: 'ctrl', action: 'act'} ));
        $row.after( $edit );
        
        $edit.on('click', '.cancel', function(){
            $edit.remove();
            $row.show();
        });
        
        $edit.on('click', '.save', function(){
            console.log($(this).parent().parent().find('input'));
            return false;
        });
    }
    
    return Table;
})();

var Search = (function () {
    "use strict";
    
    function Search(){
        
    }
    
    Search.prototype.submit = function( $form ){
        var url = $form.attr('action');
        
        var request = $.ajax({
            url     : url,
            type    : 'post',
            data    : $form.toJSON()
        });
        
        request.done(function( response ){
            $form.replaceWith( response );
        });
        
        return false;
    }
    
    return Search;
})();

var Settings = (function () {
    "use strict";
    
    function Settings( options ){
        var defaults = {
            table: $(''),
            editTemplate: ''
        };
        
        options = $.extend(defaults, options);
        this.editTemplate = options.editTemplate;
        
        this.table = new Table( options );      
    }
    
    return Settings;
})();

var Menu = (function(){
    "use strict";
    
    function Menu( $menu ){
        this.$menu = $menu;
        
        this.__menu('.first.level');
        this.__menu('.second.level');
        this.__menu('.third.level');
    }
    
    Menu.prototype.__menu = function( level ){
        var $level = this.$menu.find( level ).children();
        
        $level.on('click', '> a i', function(){
            $(this).toggleClass('icon-sort-down').toggleClass('icon-sort-up');
            var $ul = $(this).parent().siblings();
            
            if ( $ul.length ){
                $ul.slideToggle();
                
                return false;
            }
        });
    }
    
    return Menu;
})();

var Modal = (function () {
    function Modal( options ){
        var modal = this;                
        this.$loader = $('<img src="http://manage-expenses.com/img/icons/loader-spinner.gif"/>');
    }
    
    Modal.prototype.open = function( url, data ){
        this.$modal = this.modal( data );
        $('body').append( this.$modal );
        
        var $modalbody = this.$modal.children('.modal-body');
        var $form = '';
        var $save = this.$modal.find('button.save');
        
        $modalbody.html(this.$loader);
        this.$modal.modal('show');
        
        $modalbody.load( url + ' form', function(){
            $form = $modalbody.find('form');
        
            $form.off('keypress');
            $form.on('keypress', 'input', function(e){
                if ( e.which == 13 )
                    $save.trigger('click');
            });
        });
        
        $save.off('click');
        $save.on('click', function(){            
            var request = $.ajax({
                url     : $form.attr('action'),
                data    : $form.serialize(),
                type    : 'PUT'
            });
            
            request.done(function( response ) {
                $form = $(response).children('form');
                $modalbody.html( $form );
                
                $form.off('keypress');
                $form.on('keypress', 'input', function(e){
                    if ( e.which == 13 )
                        $save.trigger('click');
                });
            });
        });
               
        return false;
    }
    
    Modal.prototype.close = function ( args ) {
        this.$modal.modal('hide').remove();  
    }
    
    Modal.prototype.modal = function ( args ) {
        var closeButton = '';
        var saveButton = '';
        
        if ( args.modalClose ){
            closeButton = '<button class="btn" data-dismiss="modal" aria-hidden="true" onclick="modal.close()"><%= modalClose %></button>';
        }
        
        if ( args.modalSave ){
            saveButton = '<button class="btn btn-primary save"><%= modalSave %></button>';
        }
        
        return $(_.template(
            '<div class="modal hide fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="label" aria-hidden="true">'+
                '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
                    '<h3 id="label"><%= modalHeader %></h3>'+
                '</div>'+
                '<div class="modal-body"></div>'+
                '<div class="modal-footer">'+
                    closeButton +
                    saveButton + 
                '</div>'+
            '</div>',
            args)
        );
    }
    
    return Modal;
})();

var Permissions = (function () {
    function Permissions( $permissions ){
        this.$permissions = $permissions;
        this.$loader = $('<img src="http://manage-expenses.com/img/icons/loader-spinner.gif"/>');
        
        this.events();
    }
    
    Permissions.prototype.events = function () {
        this.$permissions.on('click', '.input.checkbox', function(e){
            var $this = $(this);
            var $form = $this.closest('form');
            
            var request = $.ajax({
                url         : $form.attr('action'),
                data        : $form.serialize(),
                type        : 'POST',
                dataType    : 'json'
            });
            
            request.done(function(response){
                if ( response.success === false ){
                    $this.attr('checked', !$this.attr('checked'));    
                }
            });
        });
    }
        
    return Permissions;
})();

(function($) {
$.fn.toJSON = function() {

   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};
})(jQuery);