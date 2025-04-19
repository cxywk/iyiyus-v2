define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cerman/index' + location.search,
                    add_url: 'cerman/add',
                    edit_url: 'cerman/edit',
                    del_url: 'cerman/del',
                    multi_url: 'cerman/multi',
                    import_url: 'cerman/import',
                    table: 'cerman',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),visible:false},
                        {field: 'kami', title: __('卡密')},
                        {field: 'jh', title: __('激活'),searchList: {0: '未激活', 1: '已激活'}, formatter: Table.api.formatter.label},
                        {field: 'jhtime', title: __('激活时间'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'uuid', title: __('Uuid'), operate: 'LIKE'},
                        {field: 'cermid', title: __('Cermid'), operate: 'LIKE'},
                        {field: 'cermdata', title: __('Cermdata'), searchList: {"0":__('Cermdata 0'),"1":__('Cermdata 1'),"2":__('Cermdata 2'),"3":__('Cermdata 3')}, formatter: Table.api.formatter.normal},
                        {field: 'pooldata', title: __('Pooldata'), searchList: {"0":__('Pooldata 0'),"1":__('Pooldata 1')}, formatter: Table.api.formatter.normal},
                        {field: 'typedata', title: __('Typedata'), searchList: {"0":__('Typedata 0'),"1":__('Typedata 1')}, formatter: Table.api.formatter.normal},
                        {field: 'sjyp', title: __('时效'),searchList: {1: '月卡', 2: '半年', 3: '一年'}, formatter: Table.api.formatter.label},
                        {field: 'beizhu', title: __('Beizhu'), operate: 'LIKE'},
                        {field: 'statedata', title: __('Statedata'), searchList: {"0":__('Statedata 0'),"1":__('Statedata 1')}, formatter: Table.api.formatter.normal},
                        {field: 'warrantydata', title: __('Warrantydata'), searchList: {"0":__('Warrantydata 0'),"1":__('Warrantydata 1')}, formatter: Table.api.formatter.normal},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'warrantytime', title: __('Warrantytime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'p12file', title: __('P12file'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'mbfile', title: __('Mbfile'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'zipfile', title: __('Zipfile'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate,
                            buttons:
                            [
                                {
                                    name: 'ajax',
                                    text: __('查询证书'),
                                    title: __('查询证书'),
                                    classname: 'btn btn-xs btn-info btn-magic btn-ajax',
                                    icon: 'fa fa-magic',
                                    url: 'cerman/getcertificate',
                                    confirm: '请确认是否进行查询证书操作?',
                                    success: function (data, ret) {
                                        Layer.alert(ret.msg);
                                        table.bootstrapTable('refresh');
                                        //如果需要阻止成功提示，则必须使用return false;
                                        //return false;
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                },
                            ]
                        }
                    ]
                ]
            });
            $(document).on("click", "#btn-mark", function(){
                //事件处理
                Fast.api.ajax('cerman/getcertificate_all')
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
