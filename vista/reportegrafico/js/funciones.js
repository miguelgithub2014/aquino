function cargar_php(pagina,capa){
        $('#'+capa).html("<br/><img src='"+url+"lib/img/loading.gif' />");
        $('#'+capa).load(url+"reportegrafico/"+pagina,function(){
            $('#'+capa).show("slow");
        });
    }
