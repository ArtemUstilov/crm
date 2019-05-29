$(document).ready(function(){
    $.get('./api/getVgTypes.php', (res)=>{
            const html = convertVgDataToList(res);
            $('#vg-types').append(html);
            $('vg-types')
        }, 'json');
    $('#vg-sum').change(()=>{
        const perc = $('#vg-types').attr('perc');

    })
});

function convertVgDataToList(data){
    return data['vgs']
        .map(row=> `<option value="${row['vg_id']}" perc="${row['out_percent']}">${row['name']}</option>`)
        .join('\n');
}