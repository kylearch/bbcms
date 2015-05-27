//     Backbone.Model File Upload v1.0.0
//     by Joe Vu - joe.vu@homeslicesolutions.com
//     For all details and documentation:
//     https://github.com/homeslicesolutions/backbone-model-file-upload
//     Contributors:
//       lutherism - Alex Jansen - alex.openrobot.net
//       bildja - Dima Bildin - github.com/bildja
//       Minjung - Alejandro - github.com/Minjung
//       XemsDoom - Luca Moser - https://github.com/XemsDoom
//       DanilloCorvalan  - Danillo Corvalan - https://github.com/DanilloCorvalan

/**
* 
*  Copyright (c) 2014 Joe Vu, Homeslice Solutions
*
*  Permission is hereby granted, free of charge, to any person obtaining a copy
*  of this software and associated documentation files (the "Software"), to deal
*  in the Software without restriction, including without limitation the rights
*  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
*  copies of the Software, and to permit persons to whom the Software is
*  furnished to do so, subject to the following conditions:
*
*  The above copyright notice and this permission notice shall be included in
*  all copies or substantial portions of the Software.
*
*  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
*  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
*  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
*  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
*  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
*  THE SOFTWARE.
* 
**/

(function(root, factory) {

  // AMD
  if (typeof define === 'function' && define.amd) {
    define(['underscore', 'jquery', 'backbone'], function(_, $, Backbone){
      factory(root, Backbone, _, $);
    });

  // NodeJS/CommonJS
  } else if (typeof exports !== 'undefined') {
    var _ = require('underscore'), $ = require('jquery'), Backbone = require('backbone');
    factory(root, Backbone, _, $);

  // Browser global
  } else {
    factory(root, root.Backbone, root._, root.$);
  }

}(this, function(root, Backbone, _, $) {
  'use strict';

  // Clone the original Backbone.Model.prototype as superClass
  var _superClass = _.clone( Backbone.Model.prototype );

  // Extending out
  var BackboneModelFileUpload = Backbone.Model.extend({

    // ! Default file attribute - can be overwritten
    fileAttribute: 'file',

    // @ Save - overwritten
    save: function(key, val, options) {

      // Variables
      var attrs, attributes = this.attributes;

      // Signature parsing - taken directly from original Backbone.Model.save
      // and it states: 'Handle both "key", value and {key: value} -style arguments.'
      if (key == null || typeof key === 'object') {
        attrs = key;
        options = val;
      } else {
        (attrs = {})[key] = val;
      }

      // Validate & wait options - taken directly from original Backbone.Model.save
      options = _.extend({validate: true}, options);
      if (attrs && !options.wait) {
        if (!this.set(attrs, options)) return false;
      } else {
        if (!this._validate(attrs, options)) return false;
      }

      // Merge data temporarily for formdata
      var mergedAttrs = _.extend({}, attributes, attrs);

      if (attrs && options.wait) {
        this.attributes = mergedAttrs;
      }

      // Check for "formData" flag and check for if file exist.
      if ( options.formData === true
        || options.formData !== false
        && mergedAttrs[ this.fileAttribute ]
        && mergedAttrs[ this.fileAttribute ] instanceof File
        || mergedAttrs[ this.fileAttribute ] instanceof FileList
        || mergedAttrs[ this.fileAttribute ] instanceof Blob ) {

        // Flatten Attributes reapplying File Object
        var formAttrs = _.clone( mergedAttrs ),
          fileAttr = mergedAttrs[ this.fileAttribute ];
        formAttrs = this._flatten( formAttrs );
        formAttrs[ this.fileAttribute ] = fileAttr;

        // Converting Attributes to Form Data
        var formData = new FormData();
        _.each( formAttrs, function( value, key ){
          if (value instanceof FileList) {
            _.each(value, function(file) {
              formData.append( key, file );
            });
            return;
          }
          formData.append( key, value );
        });

        // Set options for AJAX call
        options.data = formData;
        options.processData = false;
        options.contentType = false;

        // Apply custom XHR for processing status & listen to "progress"
        var that = this;
        options.xhr = function() {
          var xhr = $.ajaxSettings.xhr();
          xhr.upload.addEventListener('progress', that._progressHandler.bind(that), false);
          return xhr;
        }
      }

      // Resume back to original state
      if (attrs && options.wait) this.attributes = attributes;

      // Continue to call the existing "save" method
      return _superClass.save.call(this, attrs, options);

    },

    // _ FlattenObject gist by "penguinboy".  Thank You!
    // https://gist.github.com/penguinboy/762197
    // NOTE for those who use "<1.0.0".  The notation changed to nested brackets
    _flatten: function flatten( obj ) {
      var output = {};
      for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
          var flatObject = flatten(obj[i]);
          for (var x in flatObject) {
            if (!flatObject.hasOwnProperty(x)) continue;
            output[i + '[' + x + ']'] = flatObject[x];
          }
        } else {
          output[i] = obj[i];
        }
      }
      return output;

    },

    // An "Unflatten" tool which is something normally should be on the backend
    // But this is a guide to how you would unflatten the object
    _unflatten: function unflatten(obj, output) {
      var re = /^([^\[\]]+)\[(.+)\]$/g;
      output = output || {};
      for (var key in obj) {
        var value = obj[key];
        if (!key.toString().match(re)) {
          var tempOut = {};
          tempOut[key] = value;
          _.extend(output, tempOut);
        } else {
          var keys = _.compact(key.split(re)), tempOut = {};
          tempOut[keys[1]] = value;
          output[keys[0]] = unflatten( tempOut, output[keys[0]] )
        }
      }
      return output;
    },

    // _ Get the Progress of the uploading file
    _progressHandler: function( event ) {
      if (event.lengthComputable) {
        var percentComplete = Math.ceil((event.loaded / event.total) * 100);
        this.trigger( 'progress', percentComplete );
      }
    }
  });

  // Export out to override Backbone Model
  Backbone.Model = BackboneModelFileUpload;

}));