(function ($) {
    $.fn.hit = function (e, n, o, a) {
        var t = 0, d = 0, i = function (e, n, o) {
            2 > t ? (t += 1, 0 == d && (d = 1, setTimeout(function () {
                d = 0, i(e, n, o)
            }, 200))) : ($(o).load(n + (-1 != n.indexOf("?") ? "&" : "?") + "pesq=" + encodeURIComponent($(e).val()), $.fn.ajaxTo), t = 0)
        }, c = 0;
        try {
            c = e.which ? e.which : e.keyCode
        } catch (f) {
            c = 13
        }
        "" != String.fromCharCode(c) && (-2 == n ? $(a).load(o + (-1 != o.indexOf("?") ? "&" : "?") + "pesq=" + encodeURIComponent($(n).val()), $.fn.ajaxTo) : (-1 == n && (n = 0), 5 > t ? (t = 0, 13 == c ? $(a).load(o + (-1 != o.indexOf("?") ? "&" : "?") + "pesq=" + encodeURIComponent($(n).val()), $.fn.ajaxTo) : i(n, o, a)) : alert("Pesquisa bloqueada " + t)))
    };
    $.fn.msgType = function (n, f) {
        return '<p class="text-' + n + '">' + f + "</p>"
    };
    $.fn.execJs = function (c) {
        var re = /<script\b[^>]*>([\s\S]*?)<\/script>/gm, match;
        window.setTimeout(function () {
            for (; match = re.exec(c);)
                eval(match[1])
        }, 50)
    };
    $.fn.rmJs = function (r) {
        return r.replace(/<script\b[^>]*>([\s\S]*?)<\/script>/gm, "")
    };
    $.fn.ajax = function (t, e, progress) {
        if (this.bindFunction = function (t, e) {
            return function () {
                return t.apply(e, [e])
            }
        }, this.stateChange = function (t) {
            4 == this.request.readyState && this.callbackFunction(this.request.responseText)
        }, this.getRequest = function () {
            return window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : window.XMLHttpRequest ? new XMLHttpRequest : !1
        }, this.postBody = arguments[2] || "", this.callbackFunction = e, this.url = t, this.request = this.getRequest(), this.request) {
            var s = this.request;
            s.upload.onprogress = arguments[3],
                s.onreadystatechange = this.bindFunction(this.stateChange, this), "" !== this.postBody ? (s.open("POST", t, !0), s.setRequestHeader("X-Requested-With", "XMLHttpRequest"), s.setRequestHeader("Content-type", "application/x-www-form-urlencoded")) : s.open("GET", t, !0), s.send(this.postBody)
        }
    };
    $.fn.mask = function (t, f, l) {
        var m_num = function (e) {
            return e = e.replace(/\D/g, "")
        }, m_dec_3 = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 18), e = "" != e ? parseInt(e) : "", e = m_pad(e.toString(), 4), e = e.replace(/(\d)(\d{3})$/g, "$1,$2"), e = e.replace(/(\d)(\d{3})\,(\d{3})$/g, "$1.$2,$3"), e = e.replace(/(\d)(\d{3})\.(\d{3})\,(\d{3})$/g, "$1.$2.$3,$4"), e = e.replace(/(\d)(\d{3})\.(\d{3})\.(\d{3})\,(\d{3})$/g, "$1.$2.$3.$4,$5")
        }, m_dec_2 = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 18), e = "" != e ? parseInt(e) : "", e = m_pad(e.toString(), 3), e = e.replace(/(\d)(\d{2})$/g, "$1,$2"), e = e.replace(/(\d)(\d{3})\,(\d{2})$/g, "$1.$2,$3"), e = e.replace(/(\d)(\d{3})\.(\d{3})\,(\d{2})$/g, "$1.$2.$3,$4"), e = e.replace(/(\d)(\d{3})\.(\d{3})\.(\d{3})\,(\d{2})$/g, "$1.$2.$3.$4,$5")
        }, m_dec_1 = function (e) {
            return e = e.replace(/\D/g, ""), e = "" != e ? parseInt(e) : "", e = m_pad(e.toString(), 2), e = e.replace(/(\d)(\d{1})$/g, "$1,$2"), e = e.replace(/(\d)(\d{3})\,(\d{1})$/g, "$1.$2,$3"), e = e.replace(/(\d)(\d{3})\.(\d{3})\,(\d{1})$/g, "$1.$2.$3,$4"), e = e.replace(/(\d)(\d{3})\.(\d{3})\.(\d{3})\,(\d{1})$/g, "$1.$2.$3.$4,$5")
        }, m_data_a = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 8), e = e.replace(/^(\d{2})(\d)/g, "$1/$2"), e = e.replace(/^(\d{2})\/(\d{2})(\d)/g, "$1/$2/$3")
        }, m_data_b = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 12), e = e.replace(/^(\d{2})(\d)/g, "$1/$2"), e = e.replace(/^(\d{2})\/(\d{2})(\d)/g, "$1/$2/$3"), e = e.replace(/^(\d{2})\/(\d{2})\/(\d{4})(\d)/g, "$1/$2/$3 $4"), e = e.replace(/^(\d{2})\/(\d{2})\/(\d{4})\ (\d{2})(\d)/g, "$1/$2/$3 $4:$5")
        }, m_data_c = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 6), e = e.replace(/^(\d{2})(\d)/g, "$1/$2")
        }, m_data_d = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 4), e = e.replace(/^(\d{2})(\d)/g, "$1/$2")
        }, m_time = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 4), e = e.replace(/^(\d{2})(\d)/g, "$1:$2")
        }, m_cartao = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 16), e = e.replace(/^(\d{4})(\d)/g, "$1 $2"), e = e.replace(/^(\d{4})\ (\d{4})(\d)/g, "$1 $2 $3"), e = e.replace(/^(\d{4})\ (\d{4})\ (\d{4})(\d)/g, "$1 $2 $3 $4")
        }, m_cnpj = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 14), e = e.replace(/^(\d{2})(\d)/g, "$1.$2"), e = e.replace(/^(\d{2})\.(\d{3})(\d)/g, "$1.$2.$3"), e = e.replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/g, "$1.$2.$3/$4"), e = e.replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/g, "$1.$2.$3/$4-$5")
        }, m_cpf = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 11), e = e.replace(/^(\d{3})(\d)/g, "$1.$2"), e = e.replace(/^(\d{3})\.(\d{3})(\d)/g, "$1.$2.$3"), e = e.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/g, "$1.$2.$3-$4")
        }, m_cep = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 8), e = e.replace(/^(\d{2})(\d)/g, "$1.$2"), e = e.replace(/(\d)(\d{3})$/g, "$1-$2")
        }, m_phone = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 11), e = e.replace(/^(\d{2})(\d)/g, "($1) $2"), e = e.replace(/(\d)(\d{4})$/g, "$1-$2")
        }, m_phone2 = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 10), e = e.replace(/^(\d{2})(\d)/g, "($1) $2"), e = e.replace(/(\d)(\d{4})$/g, "$1-$2")
        }, m_authfast = function (e) {
            return e = e.replace(/\D/g, ""), e = e.substring(0, 9), e = e.replace(/^(\d{3})(\d)/g, "$1.$2"), e = e.replace(/^(\d{3})\.(\d{3})(\d)/g, "$1.$2.$3")
        }, m_apply = function (e, f) {
            var obj = e, func = f;
            window.setTimeout(function () {
                eval("obj.value = m_" + func + "('" + obj.value + "');")
            }, 1)
        }, m_pad = function (e, $, d) {
            return d = d || "0", e += "", e.length >= $ ? e : new Array($ - e.length + 1).join(d) + e
        }, keyup = $("#" + t)[0].onkeyup, onblur = $("#" + t)[0].onblur, onclick = $("#" + t)[0].onclick;
        $("#" + t)[0].onkeyup = function () {
            m_apply(this, f), null != keyup && keyup()
        }, $("#" + t)[0].onblur = function () {
            var e = this.value;
            switch (e = e.replace(/\D/g, ""), f) {
                case "phone":
                    11 != e.length && 10 != e.length && (this.value = "");
                    break;
                case "phone2":
                    10 != e.length && (this.value = "");
                    break;
                case "cep":
                    8 != e.length && (this.value = "");
                    break;
                case "cpf":
                    11 != e.length && (this.value = "");
                    break;
                case "cnpj":
                    14 != e.length && (this.value = "");
                    break;
                case "data_a":
                    8 != e.length && (this.value = "");
                    break;
                case "data_b":
                    12 != e.length && (this.value = "");
                    break;
                case "data_c":
                    6 != e.length && (this.value = "");
                    break;
                case "data_d":
                    4 != e.length && (this.value = "");
                    break;
                case "cartao":
                    16 != e.length && (this.value = "");
                    break;
                case "time":
                    4 != e.length && (this.value = "")
                case "authfast":
                    9 != e.length && (this.value = "")
            }
            null != onblur && onblur()
        }, $("#" + t)[0].onclick = function () {
            "function" == typeof this.select && this.select(), null != onclick && onclick()
        }, void 0 != typeof l && l === !0 && m_apply($("#" + t)[0], f)
    };
    $.fn.progresso = {
        start: function () {
            this.stop();
            $.fn.modeloModal('', 'Processando...<span id="progress-upload"></span>', undefined, 'modal-sm');
        },
        stop: function () {
            $('#myModal').modal('hide');
            $('.modal-backdrop').remove();
        }
    };
    $.fn.msg = {
        show: function (t, m, c) {
            var f = $('<div></div>')
                .attr('class', 'modal-footer')
                .append($('<button></button>')
                    .html('OK')
                    .attr('type', 'button')
                    .attr('class', 'btn btn-primary')
                    .attr('data-dismiss', 'modal')
                    .click(function () {
                        if (typeof (c) == 'function') {
                            c();
                        }
                    }));

            $.fn.modeloModal(t, m, f);

        },
        confirm: function (t, m, s, n) {
            var f = $('<div></div>')
                .attr('class', 'modal-footer')
                .append($('<button></button>')
                    .html('Sim')
                    .attr('type', 'button')
                    .attr('class', 'btn btn-success')
                    .click(function () {
                        if (typeof (s) == 'function') {
                            s();
                        }
                    }))
                .append($('<button></button>')
                    .html('Não')
                    .attr('type', 'button')
                    .attr('class', 'btn btn-danger')
                    .attr('data-dismiss', 'modal')
                    .click(function () {
                        if (typeof (s) == 'function') {
                            n();
                        }
                    }));

            $.fn.modeloModal(t, m, f);
        }
    };
    $.fn.modeloModal = function (t, b, f, s) {
        if (typeof (s) == 'undefined') {
            s = '';
        }
        window.setTimeout(function () {
            $('#myModal .modal-title').html('');
            $('#myModal .modal-body').html('');
            $('#myModal .modal-footer').remove();
            $('#myModal .modal-dialog').attr('class', 'modal-dialog');
            $('#myModal .modal-dialog').addClass(s);
            if (t != '') {
                $('#myModal .modal-header').show();
                $('#myModal .modal-title').html(t);
            } else {
                $('#myModal .modal-header').hide();
            }
            if (b != '') {
                $('#myModal .modal-body').html(b).show();
            } else {
                $('#myModal .modal-body').hide();
            }
            if (typeof (f) != 'undefined') {
                $('#myModal .modal-content').append(f);
            }
            $('#myModal').modal('show');
            $('#myModal').on('shown.bs.modal', function () {
                $.fn.ajaxTo();
            })
        }, 100);
    }
    $.fn.selectFiles = function (b, m) {
        var f = document.createElement('input');
        f.type = 'file';
        if (typeof (m) != 'undefined') {
            f.setAttribute('multiple', 'multiple');
        }
        f.click();
        f.onchange = function (e) {
            var files = e.currentTarget.files;
            i = 0;
            for (i = 0; i < files.length; i++) {
                file = files[i];
                var fr = new FileReader;
                fr.fileName = file.name;
                fr.fileSize = file.size;
                fr.onloadend = b;
                fr.readAsDataURL(file);
            }
        }
    }
    $.fn.submitEnterForm = function (id) {
        $('#' + id)[0].click();
        return false;
    }
    $.fn.ajaxData = function (e) {
        if (typeof ($(e).attr('data-editor')) != 'undefined') {
            var eds = $(e).attr('data-editor').split('|'), id = null;
            for (i = 0; i < eds.length; i++) {
                id = eds[i];
                $('#' + id).val(nicEditors.findEditor(id + '-editor').getContent());
            }
        }
        return {
            url: $(e).attr('data-url'),
            form: $(e).attr('data-form'),
            to: $(e).attr('data-to'),
            modal: typeof ($(e).attr('data-modal')) != 'undefined' ? $(e).attr('data-modal') : '0',
            text: typeof ($(e).attr('data-text')) != 'undefined' ? $(e).attr('data-text') : '',
            method: $(e).attr('data-method'),
            confirm: $(e).attr('data-confirm'),
            progress: typeof ($(e).attr('data-progress')) != 'undefined' ? $(e).attr('data-progress') : '1',
            data: typeof ($(e).attr('data-form')) != 'undefined' ? $('#' + $(e).attr('data-form') + ' input[type=\'text\'], #' + $(e).attr('data-form') + ' input[type=\'password\'], #' + $(e).attr('data-form') + ' input[type=\'hidden\'], #' + $(e).attr('data-form') + ' input[type=\'radio\']:checked, #' + $(e).attr('data-form') + ' input[type=\'checkbox\']:checked, #' + $(e).attr('data-form') + ' select, #' + $(e).attr('data-form') + ' textarea') : undefined
        };
    }
    $.fn.ajaxTo = function () {
        $('.ajax-to').each(function () {
            $(this).removeClass('ajax-to');
            var ev = $(this).attr('data-event');
            if (typeof (ev) != 'undefined') {
                switch (ev) {
                    case 'form':
                        $(this).submit(function () {
                            var obj = $.fn.ajaxData(this);
                            var f = function () {
                                $('#' + obj.to).html(obj.text);
                                if (obj.modal != '3')
                                    $('#box-modal').remove();
                                if (obj.progress == '1')
                                    $.fn.progresso.start();
                                if (obj.method == 'post') {
                                    $.post(obj.url, obj.data, function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                } else if (obj.method == 'get') {
                                    $.get(obj.url + (typeof (obj.data) != 'undefined' ? (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data.serialize() : ''), function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                }
                            }
                            if (typeof (obj.confirm) != 'undefined') {
                                obj.confirm = obj.confirm.split('||');
                                $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), f);
                            } else {
                                f();
                            }
                            return false;
                        });
                        break;
                    case 'click':
                        $(this).click(function () {
                            this.blur();
                            var obj = $.fn.ajaxData(this);
                            var f = function () {
                                $('#' + obj.to).html(obj.text);
                                if (obj.modal != '3')
                                    $('#box-modal').remove();
                                if (obj.progress == '1')
                                    $.fn.progresso.start();
                                if (obj.method == 'post') {
                                    $.post(obj.url, obj.data, function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                } else if (obj.method == 'get') {
                                    $.get(obj.url + (typeof (obj.data) != 'undefined' ? (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data.serialize() : ''), function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                }
                            }
                            if (typeof (obj.confirm) != 'undefined') {
                                obj.confirm = obj.confirm.split('||');
                                $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), f);
                            } else
                                f();
                        });
                        break;
                    case 'blur':
                        $(this).blur(function () {
                            var obj = $.fn.ajaxData(this);
                            var f = function () {
                                $('#' + obj.to).html(obj.text);
                                if (obj.modal != '3')
                                    $('#box-modal').remove();
                                if (obj.progress == '1')
                                    $.fn.progresso.start();
                                if (obj.method == 'post') {
                                    $.post(obj.url, obj.data, function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                } else if (obj.method == 'get') {
                                    $.get(obj.url + (typeof (obj.data) != 'undefined' ? (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data.serialize() : ''), function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                }
                            }
                            if (typeof (obj.confirm) != 'undefined') {
                                obj.confirm = obj.confirm.split('||');
                                $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), f);
                            } else
                                f();
                        });
                        break;
                    case 'change':
                        $(this).change(function () {
                            var obj = $.fn.ajaxData(this);
                            var f = function () {
                                $('#' + obj.to).html(obj.text);
                                if (obj.modal != '3')
                                    $('#box-modal').remove();
                                if (obj.progress == '1')
                                    $.fn.progresso.start();
                                if (obj.method == 'post') {
                                    $.post(obj.url, obj.data, function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                } else if (obj.method == 'get') {
                                    $.get(obj.url + (typeof (obj.data) != 'undefined' ? (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data.serialize() : ''), function (res) {
                                        if (obj.modal == '0' || obj.modal == '3') {
                                            if (obj.progress == '1')
                                                $.fn.progresso.stop();
                                            $.fn.execJs(res);
                                            res = $.fn.rmJs(res);
                                            if (res.trim() != '') {
                                                $('#' + obj.to).html(res);
                                            }
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        } else {
                                            if (typeof (res.redirect) != 'undefined') {
                                                document.location.href = res.titulo;
                                                return;
                                            }
                                            $.fn.modeloModal(res.titulo, res.corpo);
                                            window.setTimeout(function () {
                                                $.fn.ajaxTo();
                                            }, 50);
                                        }
                                    });
                                }
                            }
                            if (typeof (obj.confirm) != 'undefined') {
                                obj.confirm = obj.confirm.split('||');
                                $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), f);
                            } else
                                f();
                        });
                        break;
                    case 'enter':
                        $(this).keypress(function (e) {
                            if (e.which == 13 && $('#show-message').length == 0) {
                                var obj = $.fn.ajaxData(this);
                                var f = function () {
                                    $('#' + obj.to).html(obj.text);
                                    if (obj.modal != '3')
                                        $('#box-modal').remove();
                                    if (obj.progress == '1')
                                        $.fn.progresso.start();
                                    if (obj.method == 'post') {
                                        $.post(obj.url, obj.data, function (res) {
                                            if (obj.modal == '0' || obj.modal == '3') {
                                                if (obj.progress == '1')
                                                    $.fn.progresso.stop();
                                                $.fn.execJs(res);
                                                res = $.fn.rmJs(res);
                                                if (res.trim() != '') {
                                                    $('#' + obj.to).html(res);
                                                }
                                                window.setTimeout(function () {
                                                    $.fn.ajaxTo();
                                                }, 50);
                                            } else {
                                                if (typeof (res.redirect) != 'undefined') {
                                                    document.location.href = res.titulo;
                                                    return;
                                                }
                                                $.fn.modeloModal(res.titulo, res.corpo);
                                                window.setTimeout(function () {
                                                    $.fn.ajaxTo();
                                                }, 50);
                                            }
                                        });
                                    } else if (obj.method == 'get') {
                                        $.get(obj.url + (typeof (obj.data) != 'undefined' ? (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data.serialize() : ''), function (res) {
                                            if (obj.modal == '0' || obj.modal == '3') {
                                                if (obj.progress == '1')
                                                    $.fn.progresso.stop();
                                                $.fn.execJs(res);
                                                res = $.fn.rmJs(res);
                                                if (res.trim() != '') {
                                                    $('#' + obj.to).html(res);
                                                }
                                                window.setTimeout(function () {
                                                    $.fn.ajaxTo();
                                                }, 50);
                                            } else {
                                                if (typeof (res.redirect) != 'undefined') {
                                                    document.location.href = res.titulo;
                                                    return;
                                                }
                                                $.fn.modeloModal(res.titulo, res.corpo);
                                                window.setTimeout(function () {
                                                    $.fn.ajaxTo();
                                                }, 50);
                                            }
                                        });
                                    }
                                }
                                if (typeof (obj.confirm) != 'undefined') {
                                    obj.confirm = obj.confirm.split('||');
                                    $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), f);
                                } else {
                                    f();
                                }
                                e.preventDefault();
                                return false;
                            }
                        });
                        break;
                    case 'sair':
                        $(this).click(function () {
                            this.blur();
                            $.fn.msg.confirm('Atenção!', $.fn.msgType('danger', 'Deseja realmente se desconectar do sistema?'), function () {
                                document.location.href = $('base').attr('href') + 'acesso/finalizar-sessao';
                            })
                        });
                        break;
                    case 'key-hit':
                        $(this).keyup(function (e) {
                            var obj = $.fn.ajaxData(this);
                            if (typeof (obj.url) != 'undefined') {
                                obj.data = obj.data.serialize();
                                $.fn.hit(e, this, obj.url + (obj.url.indexOf('?') != -1 ? '&' : '?') + obj.data, '#' + obj.to);
                            }
                        });
                        break;
                    case 'upload-one':
                        var obj = $.fn.ajaxData(this);
                        var r = new Resumable({
                            target: obj.url,
                            chunkSize: 1 * 1024 * 1024,
                            simultaneousUploads: 1,
                            testChunks: false,
                            throttleProgressCallbacks: 1,
                            maxFiles: 1
                        });
                        r.assignBrowse(this);
                        r.on('fileSuccess', function (file, res) {
                            var json = JSON.parse(res);
                            if (json.error) {
                                $.fn.msg.show('Atenção', $.fn.msgType('danger', json.error));
                            }

                            if (json.redirect) {
                                document.location.href = json.redirect;
                            }
                        });
                        r.on('fileAdded', function (file, event) {
                            r.upload();
                        });
                        r.on('uploadStart', function () {
                            if (obj.progress == '1')
                                $.fn.progresso.start();
                        });
                        r.on('complete', function () {
                            if (obj.progress == '1')
                                $.fn.progresso.stop();
                        });
                        r.on('progress', function () {
                            $('#progress-upload').css('display', 'inline-block');
                            $('#progress-upload').html(parseInt(r.progress() * 100) + '%');
                        });
                        break;
                    case 'upload-multiple':
                        var obj = $.fn.ajaxData(this);
                        var redirecionar = '';
                        var r = new Resumable({
                            target: obj.url,
                            chunkSize: 1 * 1024 * 1024,
                            simultaneousUploads: 1,
                            testChunks: false,
                            throttleProgressCallbacks: 1,
                            maxFiles: 20
                        });
                        r.assignBrowse(this);
                        r.on('fileSuccess', function (file, res) {
                            var json = JSON.parse(res);
                            if (json.error) {
                                $.fn.msg.show('Atenção', $.fn.msgType('danger', json.error));
                            }
                            redirecionar = json.redirect;
                        });
                        r.on('fileAdded', function (file, event) {
                            r.upload();
                        });
                        r.on('uploadStart', function () {
                            if (obj.progress == '1')
                                $.fn.progresso.start();
                        });
                        r.on('complete', function () {
                            if (obj.progress == '1') {
                                $.fn.progresso.stop();
                                document.location.href = redirecionar;
                            }
                        });
                        r.on('progress', function () {
                            $('#progress-upload').css('display', 'inline-block');
                            $('#progress-upload').html(parseInt(r.progress() * 100) + '%');
                        });
                        break;
                    case 'click_confirm':
                        $(this).click(function () {
                            this.blur();
                            var obj = $.fn.ajaxData(this);
                            if (typeof (obj.confirm) != 'undefined') {
                                obj.confirm = obj.confirm.split('||');
                                $.fn.msg.confirm(obj.confirm[0], $.fn.msgType('danger', obj.confirm[1]), function () {
                                    document.location.href = obj.url;
                                });
                            }
                        });
                        break;
                }
            } else {
                console.log('aplicar data-event no elemento');
                console.log(this);
            }
        });
    }
    $('head').append(
        $('<style></style>').html('' +
            '.scroll-hidden{overflow: hidden;}' +
            '#progress-upload{display:none;margin-left:10px;font-weight:bold;color:#900;font-size:18px;}' +
            '.bg-modal{background:rgba(0,0,0,0.5);position:fixed;left:0;right:0;top:0;bottom:0;z-index:100;overflow:auto;padding:20px 0;}' +
            '.bg-modal .container .row .conteudo {margin-top:0 !important;}' +
            '.bg-modal .container .row .conteudo .box{padding:0 15px;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;background: #fff;position: relative;}' +
            '.bg-modal .container .row .conteudo .box a.fechar{position:absolute;z-index:101;right:-11px;top:-11px;background: #ddd;color: #333;-webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;height: 32px;display: inline-block;vertical-align: middle;width: 32px;line-height: 32px;text-align: center;}' +
            '.bg-modal .container .row .conteudo .box a.fechar:hover { background: #062c53; }' +
            '.bg-modal .container .row .conteudo .box .linha { height: 35px; background-image: url(../../img/site/bg-tit-modal.jpg); background-repeat: repeat-x;background-position: left center; }' +
            '.bg-modal .container .row .conteudo .box .linha .tit {display: inline-block;vertical-align: middle;height: 35px;line-height: 35px;background: #ddd;color: #333;font-size: 16px;color: #333;padding: 0 20px;text-transform: uppercase;-webkit-border-radius: 7px;-moz-border-radius: 7px;border-radius: 7px;margin-right: 10px;cursor: pointer;}' +
            '.bg-modal .container .row .conteudo .box .linha .tit.active { background: #062c53; }' +
            'div#show-progress { position: fixed; z-index: 200; left: 0; right: 0; top: 0; bottom: 0; background: rgba(0,0,0,0.0); }' +
            'div#show-progress div.tit {font-size: 18px;line-height: 40px;text-align: center; color:#333; height: 40px; background: #ffe400;-webkit-border-top-left-radius: 25px; -webkit-border-top-right-radius: 25px;-moz-border-radius-topleft: 25px;-moz-border-radius-topright: 25px;border-top-left-radius: 25px;border-top-right-radius: 25px;-webkit-border-bottom-right-radius: 20px;-webkit-border-bottom-left-radius: 20px;-moz-border-radius-bottomright: 20px;-moz-border-radius-bottomleft: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;margin-top: 50px;}' +
            'div#show-message { position: fixed; z-index: 200; left: 0; right: 0; top: 0; bottom: 0; background: rgba(0,0,0,0.5); overflow: auto; }' +
            'div#show-message div.bg-branco  {background: #fff;-webkit-border-top-left-radius: 25px;-webkit-border-top-right-radius: 25px;-moz-border-radius-topleft: 25px;-moz-border-radius-topright: 25px;border-top-left-radius: 25px;border-top-right-radius: 25px;-webkit-border-bottom-right-radius: 20px;-webkit-border-bottom-left-radius: 20px;-moz-border-radius-bottomright: 20px;-moz-border-radius-bottomleft: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;margin-top: 50px;}' +
            'div#show-message div.tit {font-size: 18px;line-height: 40px;text-align: center; background: #ddd; color:#333; height: 40px; -webkit-border-top-left-radius: 20px;-webkit-border-top-right-radius: 20px;-moz-border-radius-topleft: 20px;-moz-border-radius-topright: 20px;border-top-left-radius: 20px;border-top-right-radius: 20px;}' +
            'div#show-message div.msg { padding: 20px; }' +
            'div#show-message div.msg p { text-align: center; padding: 2px 20px; margin:0; font-size: 18px;}' +
            'div#show-message div.msg p a { color: #000099; text-decoration: underline; }' +
            'div#show-message div.msg p strong { font-size: 18px; }' +
            'div#show-message div.msg p.error { color: #900; }' +
            'div#show-message div.msg p.success { color: #090; }' +
            'div#show-message div.msg p.info { color: #009; }' +
            'div#show-message div.bts { text-align: center; padding: 0 0 20px 0;}' +
            'div#show-message div.bts a {font-size: 18px;display: inline-block;vertical-align: middle;padding: 0 10px;height: 32px;line-height: 32px;background: #ddd; color: #333;-webkit-border-radius: 7px;-moz-border-radius: 7px;border-radius: 7px;cursor: pointer;}' +
            'div#show-message div.bts a:hover { background: #999; }' +
            'div#show-message div.bts a:first-child { margin-right: 10px; }'
        )
    );
})(jQuery);
$(document).ready(function () {
    $.ajaxSetup({ cache: false });
    $.fn.ajaxTo();
    $(document).keyup(function (e) {
        switch (e.keyCode) {
            case 13:
                if ($('#show-message').length > 0) {
                    $('#show-message div.bts a:eq(0)')[0].click();
                    $('body').removeClass('scroll-hidden');
                }
                break;
            case 27:
                if ($('#show-message').length > 0) {
                    $('#show-message').remove();
                    $('body').removeClass('scroll-hidden');
                }
                break;
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});