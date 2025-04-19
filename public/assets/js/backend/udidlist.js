define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'udidlist/index' + location.search,
                     add_url: 'udidlist/add',
                    edit_url: 'udidlist/edit',
                    del_url: 'udidlist/del',
                    multi_url: 'udidlist/multi',
                    table: 'udidlist',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                //sortOrder: "asc",    
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'udid', title: __('UDID')},
                        {field: 'product', title: __('设备型号')},
                        {field: 'type', title: __('类型'),searchList: {0: '游客', 1: '会员'},formatter: Table.api.formatter.flag},
                        {field: 'zsid', title: __('证书编号')},
                        {field: 'sjskg', title: __('时间锁'), formatter:Table.api.formatter.toggle},
                        {field: 'disable', title: __('禁用'), formatter:Table.api.formatter.toggle},
                        {field: 'sign', title: __('签名次数')},
					    {field: 'dqtime', title: __('到期时间'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
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