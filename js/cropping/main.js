(function (factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node / CommonJS
    factory(require('jquery'));
  } else {
    factory(jQuery);
  }
})(function ($) {

  'use strict';

  var console = window.console || { log: function () {} };

  function CropAvatar($element) {
    this.$container = $element;

    this.$avatarView = this.$container.find('.avatar-view');
    this.$avatar = this.$avatarView.find('img');
    this.$avatarModal = this.$container.find('#avatar-modal');
    this.$loading = this.$container.find('.loading');

    this.$avatarForm = this.$avatarModal.find('.avatar-form');
    this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
    this.$avatarSrc = this.$avatarForm.find('.avatar-src');
    this.$avatarData = this.$avatarForm.find('.avatar-data');
    this.$avatarInput = this.$avatarForm.find('.avatar-input');
    this.$avatarSave = this.$avatarForm.find('.avatar-save');
    this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

    this.init();
    // console.log(this);
  }

  CropAvatar.prototype = {
    constructor: CropAvatar,

    support: {
      fileList: !!$('<input type="file">').prop('files'),
      blobURLs: !!window.URL && URL.createObjectURL,
      formData: !!window.FormData
    },

    init: function () {
      this.support.datauri = this.support.fileList && this.support.blobURLs;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip();
      this.initModal();
      this.addListener();
    },

    addListener: function () {
      this.$avatarView.on('click', $.proxy(this.click, this));
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarForm.on('submit', $.proxy(this.submit, this));
      this.$avatarBtns.on('click', $.proxy(this.rotate, this));
    },

    initTooltip: function () {
      this.$avatarView.tooltip({
        placement: 'bottom'
      });
    },

    initModal: function () {
      this.$avatarModal.modal({
        show: false
      });
    },

    initPreview: function () {
      var url = this.$avatar.attr('src');

      this.$avatarPreview.empty().html('<img src="' + url + '">');
    },

    initIframe: function () {
      var target = 'upload-iframe-' + (new Date()).getTime(),
          $iframe = $('<iframe>').attr({
            name: target,
            src: ''
          }),
          _this = this;

      // Ready ifrmae
      $iframe.one('load', function () {

        // respond response
        $iframe.on('load', function () {
          var data;

          try {
            data = $(this).contents().find('body').text();
          } catch (e) {
            // console.log(e.message);
          }

          if (data) {
            try {
              data = $.parseJSON(data);
            } catch (e) {
              // console.log(e.message);
            }

            _this.submitDone(data);
          } else {
            _this.submitFail('Image upload failed!');
          }

          _this.submitEnd();

        });
      });

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', target).after($iframe.hide());
    },

    click: function () {
      this.$avatarModal.modal('show');
      this.initPreview();
    },

    change: function () {
      var files,
          file;

      if (this.support.datauri) {
        files = this.$avatarInput.prop('files');

        if (files.length > 0) {
          file = files[0];

          if (this.isImageFile(file)) {
            if (this.url) {
              URL.revokeObjectURL(this.url); // Revoke the old one
            }

            this.url = URL.createObjectURL(file);
            this.startCropper();
          }
        }
      } else {
        file = this.$avatarInput.val();

        if (this.isImageFile(file)) {
          this.syncUpload();
        }
      }
    },

    submit: function () {
      if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
        return false;
      }

      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    },

    rotate: function (e) {
      var data;

      if (this.active) {
        data = $(e.target).data();

        if (data.method) {
          this.$img.cropper(data.method, data.option);
        }
      }
    },

    isImageFile: function (file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
      }
    },

    startCropper: function () {
      var _this = this;

      if (this.active) {
        // this.$img.cropper('replace', this.url);
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
      } else {
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
        // this.$img.cropper({
        //   aspectRatio: 6/3,
        //   preview: this.$avatarPreview.selector,
        //   crop: function (data) {
        //     var json = [
        //           '{"x":' + data.x,
        //           '"y":' + data.y,
        //           '"height":' + data.height,
        //           '"width":' + data.width,
        //           '"rotate":' + data.rotate + '}'
        //         ].join();

        //         document.getElementById('dataX').value = data.x;
        //         document.getElementById('dataY').value = data.y;
        //         document.getElementById('dataWidth').value = data.width;
        //         document.getElementById('dataHeight').value = data.height;
        //         document.getElementById('dataRotate').value = data.rotate;

        //     _this.$avatarData.val(json);
        //   }
        // });

        this.active = true;
      }
    },

    stopCropper: function () {
      if (this.active) {
        this.$img.cropper('destroy');
        this.$img.remove();
        this.active = false;
      }
    },

    ajaxUpload: function () {
      var url = this.$avatarForm.attr('action'),
          data = new FormData(this.$avatarForm[0]),
          _this = this;
          // console.log('===================>'+JSON.stringify(data))
      $.ajax(url, {
        type: 'post',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,

        beforeSend: function (data) {
          // console.log(JSON.stringify(data))
          _this.submitStart();
        },

        success: function (data) {
          _this.submitDone(data);
        },

        error: function (er) {
          // console.log(JSON.stringify(er))
          // _this.submitFail(textStatus || errorThrown);
        },

        complete: function () {
          _this.submitEnd();
        }
      });
    },

    syncUpload: function () {
      this.$avatarSave.click();
    },

    submitStart: function () {
      this.$loading.fadeIn();
    },

    submitDone: function (data) {

      // console.log('Done: '+JSON.stringify(data))

      if(data.appendData[1] == 'profile') {
        
      }
      else if(data.appendData[6] == 'news') {

        $('#newsTbl').DataTable().ajax.reload();

      }
      else if(data.appendData[4] == 'newsPic') {

          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/news/'+data.appendData[3]+'/slide/'+data.appendData[1]);

      }
      else if(data.appendData[6] == 'gifts') {

       $('#giftTbl').DataTable().ajax.reload();

      }
      else if(data.appendData[4] == 'giftsPic') {
        
          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/gifts/'+data.appendData[3]+'/th/'+data.appendData[1]);

      }
      else if(data.appendData[9] == 'event') {

       // ОПРЕДЕЛЕНИЕ ВРЕМЯ
        var nowtime = new Date();
        var gottime = data.appendData[8] * 1000;
        var nowtimediff = nowtime.getTime() - gottime;
        var onltime = new Date(gottime);
        var onlDateTime;
        var onlMonth;
        var onlDay;
        var onlHour;
        var onlMin;

        // DAYS AGO
        if(nowtimediff > 86400) {
          if(onltime.getMonth() < 9) {
            onlMonth = '0' + (onltime.getMonth() + 1);
          } else {
            onlMonth = onltime.getMonth() + 1;
          }

          if(onltime.getDate() < 10) {
            onlDay = '0' + onltime.getDate();
          } else {
            onlDay = onltime.getDate();
          }

          if(onltime.getHours() < 10) {
            onlHour = '0' + onltime.getHours();
          } else {
            onlHour = onltime.getHours();
          }
          if(onltime.getMinutes() < 10) {
            onlMin = '0' + onltime.getMinutes();
          } else {
            onlMin = onltime.getMinutes();
          }

          onlDateTime = onlDay + '.' + onlMonth + '.' + onltime.getFullYear() + ' ' + onlHour + ':' + onlMin;
        }
        // HOURS AND MINUTES AGO
        else {
          if(onltime.getHours() < 10) {
            onlHour = '0' + onltime.getHours();
          } else {
            onlHour = onltime.getHours();
          }
          if(onltime.getMinutes() < 10) {
            onlMin = '0' + onltime.getMinutes();
          } else {
            onlMin = onltime.getMinutes();
          }

          onlDateTime =  onlHour + ':' + onlMin;
        }

        // TIME UNTIL EVENT
        var evnttime = new Date(data.appendData[5] * 1000);
        var evntDateTime;
        var evntMonth;
        var evntDay;
        var evntHour;
        var evntMin;
        
        if(evnttime.getMonth() < 9) {
          evntMonth = '0' + (evnttime.getMonth() + 1);
        } else {
          evntMonth = evnttime.getMonth() + 1;
        }

        if(evnttime.getDate() < 10) {
          evntDay = '0' + evnttime.getDate();
        } else {
          evntDay = evnttime.getDate();
        }

        if(evnttime.getHours() < 10) {
          evntHour = '0' + evnttime.getHours();
        } else {
          evntHour = evnttime.getHours();
        }
       
        if(evnttime.getMinutes() < 10) {
          evntMin = '0' + evnttime.getMinutes();
        } else {
          evntMin = evnttime.getMinutes();
        }

        evntDateTime = evntDay + '.' + evntMonth + '.' + evnttime.getFullYear() + ' ' + evntHour + ':' + evntMin;

        var statusBtn = '';
        switch(data.appendData[4]) {
          case '0':
            statusBtn = '<button onclick="switchEvent(0, '+data.appendData[0]+')" type="button" class="btn btn-warning btn-xs">вручную</button>';
            break;
          case '1':
            statusBtn = '<button onclick="switchEvent(1, '+data.appendData[0]+')" type="button" class="btn btn-success btn-xs">автоматика</button>';
            break;
          default:
            statusBtn = '<button onclick="switchEvent(0, '+data.appendData[0]+')" type="button" class="btn btn-warning btn-xs">вручную</button>';
            break;
        }

        var t = $('#eventTbl').DataTable();

        t.row.add( [
            data.appendData[0],
            '<a>'+data.appendData[1]+'</a><br /><small><i class="fa fa-pencil"></i> '+onlDateTime+'</small><br /><small><i class="fa fa-gift"></i> '+data.appendData[7]+'</small><br /><small><i class="fa fa-shopping-cart"></i> '+data.appendData[6]+'</small>',
            '<a href="#" onclick="location.reload()">'+data.appendData[2]+'</a>',
            '<a href="#" onclick="location.reload()">'+evntDateTime+'</a>',
            '<a href="#" onclick="location.reload()"><img id="img'+data.appendData[0]+'" style="height:100px;" src="http://www.olegtronics.com/admin/img/event/'+instid+'/slide/'+data.appendData[3]+'" /></a>',
            '<a id="statbtn'+data.appendData[0]+'">'+statusBtn+'</a>',
            '<a href="#" onclick="switchEvent(2, '+data.appendData[0]+')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Удалить </a>'
        ] ).draw( false );

      }
      else if(data.appendData[4] == 'eventsPic') {
          // ОПРЕДЕЛЕНИЕ ВРЕМЯ
          var nowtime = new Date();
          var gottime = data.appendData[2] * 1000;
          var nowtimediff = nowtime.getTime() - gottime;
          var onltime = new Date(gottime);
          var onlDateTime;
          var onlMonth;
          var onlDay;
          var onlHour;
          var onlMin;

          // DAYS AGO
          if(nowtimediff > 86400) {
            if(onltime.getMonth() < 9) {
              onlMonth = '0' + (onltime.getMonth() + 1);
            } else {
              onlMonth = onltime.getMonth() + 1;
            }

            if(onltime.getDate() < 10) {
              onlDay = '0' + onltime.getDate();
            } else {
              onlDay = onltime.getDate();
            }

            if(onltime.getHours() < 10) {
              onlHour = '0' + onltime.getHours();
            } else {
              onlHour = onltime.getHours();
            }
            if(onltime.getMinutes() < 10) {
              onlMin = '0' + onltime.getMinutes();
            } else {
              onlMin = onltime.getMinutes();
            }

            onlDateTime = onlDay + '.' + onlMonth + '.' + onltime.getFullYear() + ' ' + onlHour + ':' + onlMin;
          }
          // HOURS AND MINUTES AGO
          else {
            if(onltime.getHours() < 10) {
              onlHour = '0' + onltime.getHours();
            } else {
              onlHour = onltime.getHours();
            }
            if(onltime.getMinutes() < 10) {
              onlMin = '0' + onltime.getMinutes();
            } else {
              onlMin = onltime.getMinutes();
            }

            onlDateTime =  onlHour + ':' + onlMin;
          }

          $('small#time'+data.appendData[0]).html('<i class="fa fa-pencil"></i>'+onlDateTime);
          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/event/'+data.appendData[3]+'/slide/'+data.appendData[1]);

      }
      else if(data.appendData[9] == 'categories') {

        $('#catTbl').DataTable().ajax.reload();

      }
      else if(data.appendData[4] == 'categoriesPic') {

          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/menu/'+data.appendData[3]+'/cat/'+data.appendData[1]);

      }
      else if(data.appendData[6] == 'goods') {

        $('#catTbl').DataTable().ajax.reload();

      }
      else if(data.appendData[4] == 'goodsPic') {

          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/menu/'+data.appendData[3]+'/goods/'+data.appendData[1]);

      }
      else if(data.appendData[16] == 'menue') {

       $('#menueTbl').DataTable().ajax.reload();

      }
      else if(data.appendData[4] == 'menuePic') {

          $('#img'+data.appendData[0]).attr('src', 'http://www.olegtronics.com/admin/img/menu/'+data.appendData[3]+'/150/'+data.appendData[1]);

      }

      if ($.isPlainObject(data) && data.state === 200) {
        if (data.result) {
          this.url = 'http://www.olegtronics.com/admin/'+data.result;

          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            this.uploaded = true;
            this.$avatarSrc.val(this.url);
            this.startCropper();
          }

          this.$avatarInput.val('');
        } else if (data.message) {
          this.alert(data.message);
        }
      } else {
        this.alert('Ошибка при загрузке!');
      }
    },

    submitFail: function (msg) {
      this.alert(msg);
    },

    submitEnd: function () {
      this.$loading.fadeOut();
    },

    cropDone: function () {
      this.$avatarForm.get(0).reset();
      this.$avatar.attr('src', this.url);
      this.stopCropper();
      this.$avatarModal.modal('hide');
    },

    alert: function (msg) {
      var $alert = [
            '<div class="alert alert-danger avater-alert">',
              '<button type="button" class="close" data-dismiss="alert">&times;</button>',
              msg,
            '</div>'
          ].join('');

      this.$avatarUpload.after($alert);
    }
  };

  $(function () {
    return new CropAvatar($('#crop-avatar'));
  });

});
