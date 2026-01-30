//var role_access=JSON.parse(role_access);
console.log(role_access);
var configs_list = $('#configs_list').DataTable({
    serverSide: true,
    bProcessing: true,
    order: [[1, "asc"]],
    ajax: {
        url: base_url + 'admin/Configs/listConfigs',
        type: 'POST',
        dataSrc: "data"
    },
    columnDefs: [{orderable: false, targets: [0]}],
    "columns": [
        { "title":"Sr. No.", "width": "5%"},
        { "title":"Group Field", "width": "20%"},
        { "title":"Name" ,"width": "25%"},
        { "title":"Value" ,"width": "25%"},
        { "title":"Action" ,"width": "10%",orderable: false},
    ],
    "scrollX": false
});
if(parseInt(role_access.edit)==1  || parseInt(role_access.delete)==1){
    configs_list.columns(4).visible(true);
}else{
    configs_list.columns(4).visible(false);
}

$(document).on('click', '.config_edit', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        url:base_url+'admin/Configs/getEditConfig',
        type:'post',
        data:{'id':id},
        dataType:'json',
        success: function (res) {
            if(res.result == true){
                $('#add_configs').modal('toggle');
                $('#id').val(res.configs.id);
                $('#name').val(res.configs.name);
                $('#value').val(res.configs.value);
                $('#group_field').val(res.configs.group_field);
                var $radios = $('input:radio[name=access_by]');
                if(res.configs.access_by === 1) {
                    $radios.filter('[value=1]').prop('checked', true);
                }else{
                    $radios.filter('[value=0]').prop('checked', true);
                }
            }else{
                alert(res.reason);
            }
        }

    });
});
