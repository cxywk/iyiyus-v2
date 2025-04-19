define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'zsdhm/index' + location.search,
                    add_url: 'zsdhm/add',
                    edit_url: 'zsdhm/edit',
                    del_url: 'zsdhm/del',
                    multi_url: 'zsdhm/multi',
                    table: 'zsdhm',
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
                        {field: 'kami', title: __('卡密')},
                        {field: 'jh', title: __('激活'),searchList: {0: '未激活', 1: '已激活'}, formatter: Table.api.formatter.label},
                        {field: 'shouhou', title: __('是否售后'),searchList: {1: '售后', 0: '新购'}, formatter: Table.api.formatter.label},
                        {field: 'type', title: __('证书类型'),searchList: {1: '普通版', 2: '稳定版', 3: '豪华版'}, formatter: Table.api.formatter.label},
                        {field: 'sjyp', title: __('时效'),searchList: {1: '月卡', 2: '半年', 3: '一年'}, formatter: Table.api.formatter.label},
                        {field: 'udid', title: __('UDID')},
					     {field: 'zsid', title: __('证书编号')},
					     {field: 'jhtime', title: __('激活时间'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                       {field: 'beizhu', title: __('备注')},
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