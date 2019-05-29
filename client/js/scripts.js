$(document).ready(function(){
    $.get('./api/getVgTypes.php', (res)=>{
            console.log(res);
        });
});