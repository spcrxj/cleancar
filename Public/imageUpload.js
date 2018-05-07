
$.fn.extend({
    _opt: {
        limitSize: 3,
        usestyle: false
    },
    imageUpload: function (options) {
        var _this = this,
                styles = {
                    "width": "25px",
                    "height": "20px",
                    "float": "left",
                    "margin-right": "10px",
                    "background-size": "100%"
                };
        _this._opt = $.extend(_this._opt, options);
        if (_this._opt.usestyle) {
            $(this).css(styles);
        }
        try {
            $(_this._opt.imgTar).on('change', function (e) {
                var file = e.target.files[0];
                console.log(e.target.files[0])
                if (Math.ceil(file.size / 1024 / 1024) > _this._opt.limitSize) {
                    console.error('文件太大');
                    return;
                }
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (f) {
                    _this.upload(f.target.result);
                };
            });
        } catch (e) {
            console.log(e);
        }
    },
    upload: function (data) {
        $("#loading").fadeIn(); //����
        var _this = this, filed = _this._opt.uploadField;
        $.ajax({
            url: _this._opt.uploadUrl,
            type: 'post',
            data: $.extend(_this._opt.data, {filed: data}),
            cache: false
        })
                .then(function (res) {
                    var src = _this._opt.uploadSuccess(res);
                    if (src) {
                        _this.insertImage(src);
                    } else {
                        _this._opt.uploadError(res);
                    }
                });
        //$("#loading").fadeOut();//������� 
    },
    insertImage: function (img) {
        var _this = this;
        $('#' + _this._opt.uploadField).val(img);
    }
});
