$(document).ready(function(){
    $.get('./api/getVgTypes.php', (res)=>{
            const html = convertVgDataToList(res);
            $('#vg-types').append(html);
            $('vg-types')
        }, 'json');
    $('#vg-sum').keyup(calcSum);
    $('#vg-types').change(calcSum);
});
function calcSum(res){
    const perc = $('#vg-types').find(":selected").attr('perc');
    if(!perc)
        return;
    $('#fiat-sum').text(+perc * +$('#vg-sum').val());
}
function convertVgDataToList(data){
    return data['vgs']
        .map(row=> `<option value="${row['vg_id']}" perc="${row['out_percent']}">${row['name']}</option>`)
        .join('\n');
}