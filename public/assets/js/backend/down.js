define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'down/index' + location.search,
                    add_url: 'down/add',
                    edit_url: 'down/edit',
                    del_url: 'down/del',
                    multi_url: 'down/multi',
                    table: 'shorturl',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
    
                        {field: 'udid', title: __('UDID'),formatter: Table.api.formatter.label},
					    {field: 'shortid', title: __('短链ID')},
					   {field: 'appname', title: __('APP')},
					   {field: 'bid', title: __('标识')},
					   {field: 'cs', title: __('剩余下载次数')},
					    {field: 'time', title: __('添加时间'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                       
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