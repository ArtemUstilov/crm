let storage = [];
$(document).ready(function(){
    // $.get('./api/getVgTypes.php', (res)=>{
    //         const html = convertVgDataToList(res);
    //         $('#vg-types').append(html);
    //         $('vg-types')
    //     }, 'json');
    // $('#vg-sum').keyup(calcSum);
    // $('#vg-types').change(calcSum);


    $('#login-btn').click(()=>{
       const login = $('#login').val();
       const vgSum = $('#vg-sum').val();
       $.get('./api/getClientInfo.php', {login, vgSum}, (res)=>{
           if(res.error){
               alert(res.error);
               //TODO for Roma if he wants
               return;
           }
            parseLoginData(res);
       }, 'json');
    });

    $('#pass-btn').click(()=>{
        const login = $('#login').val();
        const password = $('#pass').val();
        $.get('./api/approvePass.php', {login, password}, (res)=>{
            if(res.error){
                alert(res.error);
                //TODO for Roma if he wants
                return;
            }
            parsePassData();
        }, 'json');
    });
    $('#pay-in-debt-btn').click(function(){
        createDebtDeal();
    });
    $('#pay-system-btn').click(function(){
        createDeal();
    });
});
// function calcSum(res){
//     const perc = $('#vg-types').find(":selected").attr('perc');
//     if(!perc)
//         return;
//     $('#fiat-sum').text(+perc * +$('#vg-sum').val());
// }
// function convertVgDataToList(data){
//     return data['vgs']
//         .map(row=> `<option value="${row['vg_id']}" perc="${row['out_percent']}">${row['name']}</option>`)
//         .join('\n');
// }
function parseLoginData(res) {
    $('#vg-sum').prop('disabled', true);
    if(+res.paySystem){
        $('#pass-box').show();
    }
    $('#sum-label').show().text(`Стоимость: ${res.sum} ${res.fiatName}`);
    $('#vg-label').show().text(`VG: ${res.vgName}`);
    storage = res;
}
function parsePassData() {
    if(+storage.debtLimit > 0){
        if(+storage.debtLimit - +storage.sum < 0){
            $('#debt-limit-label').text('Лимита оплаты долгом не достаточно');
        }else{
            $('#debt-limit-label').text('Ваш лимит оплаты в долг: ' + storage.debtLimit + ' ' + storage.fiatName);
            $('#pay-in-debt-btn').show();
        }
        $('#pay-system-btn').show();
    }else{
        $('#debt-limit-label').text('Ваш лимит оплаты в долг исчерпан');
    }
    alert('parsing password...');
}

function creatDeal(){
    alert("You want to buy vg");
}

function createDebtDeal(){
    alert("You want to buy vg in debt");
}