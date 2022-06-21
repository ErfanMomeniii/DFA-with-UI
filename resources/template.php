
<!doctype html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <style>
        html, body {font: 11pt arial;}
        .text2 {
            margin-top: 20px;
            margin-left: 20px;
        }
        .t2 {
            margin-left: 20px;
            padding: 5px;
            font-size: 10pt;
            border: 1px solid;
        }
        .submit_button{
            margin-top: 60px;
            margin-left: 20px;
        }
        #network {
            width: 95%;
            height: 400px;
            border: 1px solid lightgray;
            margin-left: 20px;
            margin-right: 50px;
        }
    </style>
    <script
        type="text/javascript"
        src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"
    ></script>



    <script type="text/javascript">
        var nodes, edges, network;
        var nodes_show,edges_show;

        function toJSON(obj) {
            return JSON.stringify(obj, null, 1);
        }

        function does_contain(array,content){
            for(i=0;i<array.length;i++)
                if(array[i]===content) return true;
            return false;
        }
        function does_contain_start_state(array){
            for (i=0;i<array.length;i++){
                if (array[i].isInitial===1){
                    return true;
                }
            }
            return false;
        }
        function does_contain_label(array,content){
            for(i=0;i<array.length;i++)
                if(array[i].label===content) return true;
            return false;
        }

        function draw() {

            nodes = new vis.DataSet();
            nodes_show = new vis.DataSet();

            nodes.add([
            ]);
            nodes_show.add([
            ]);

            edges = new vis.DataSet();
            edges_show = new vis.DataSet();

            edges.add([
            ]);
            edges_show.add([
            ]);

            var container = document.getElementById("network");
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {
                manipulation: {
                    enabled: true,
                    addNode: function(nodeData,callback) {
                        $.confirm({
                            animation: "Rotate",
                            animationSpeed: 1000,
                            title: "add node",
                            content: "" +
                                '<form action="" class="formName">' +
                                '<div class="form-group">' +
                                '<label>node id</label>' +
                                '<input type="text" placeholder="" class="id form-control" required autofocus><br>' +
                                '<label>node name</label>' +
                                '<input type="text" placeholder="" class="name form-control" required />' +
                                '</div>' +
                                '<div class="form-check">' +
                                '<input type="checkbox" class="form-check-input" id="Initial">' +
                                '<label class="form-check-label" for="Initial">Initial</label>'+
                                '</div>' +
                                '<div class="form-check">' +
                                '<input type="checkbox" class="form-check-input" id="Final">' +
                                '<label class="form-check-label" for="Final">Final</label>'+
                                '</div>' +
                                '</form>',
                            buttons: {
                                formSubmit: {
                                    text: 'Submit',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        var id = this.$content.find('.id').val();
                                        var name = this.$content.find('.name').val();

                                        var isFinal = this.$content.find('#Final').is(":checked");
                                        var isInitial = this.$content.find('#Initial').is(":checked");
                                        if(!name){
                                            $.alert('provide a valid name :|');
                                            return false;}

                                        if(does_contain_label(nodes.get(),name)){
                                            alert('this id is used!!:/');
                                            return false;}
                                        if(!id){
                                            $.alert('provide a valid id :|');
                                            return false;}
                                        if(does_contain(nodes.getIds(),id)){
                                            alert('this id is used!!:/');
                                            return false;}

                                        var tmp = nodes.get();
                                        console.log(tmp);
                                        isDuplicated=0;
                                        for(n in tmp)
                                            if(tmp[n]['label']===name){
                                                isDuplicated=1;
                                                alert("duplicated node!!  -___-");
                                            }
                                        if(!isDuplicated){
                                            var new_node = {
                                                id:id,
                                                label:name
                                            };
                                            var hasproblem=false;
                                            var new_node_show = new_node;
                                            if(isFinal && isInitial){
                                                if(does_contain_start_state(nodes.get())){
                                                 alert("duplicated start state!  -___-");
                                                 hasproblem=true;
                                                }else {
                                                    new_node = Object.assign({}, new_node, {
                                                        isFinal: 1,
                                                        isInitial: 1,
                                                        shape: 'icon',
                                                        icon: {
                                                            face: 'FontAwesome',
                                                            code: '\uf188',
                                                            size: 50,
                                                            color: '#f0a30a'
                                                        }
                                                    });
                                                    new_node_show['isInitial'] = 1;
                                                    new_node_show['isFinal'] = 1;
                                                }
                                            }
                                            else if(isFinal){
                                                new_node = Object.assign({},new_node,{
                                                    isFinal:1,
                                                    shape: 'icon',
                                                    icon: {
                                                        face: 'FontAwesome',
                                                        code: '\uf140',
                                                        size: 50,
                                                        color: '#f0a30a'
                                                    }
                                                });
                                                new_node_show["isFinal"] = 1;
                                            }
                                            else if(isInitial){
                                                if(does_contain_start_state(nodes.get())){
                                                    alert("duplicated start state!  -___-");
                                                    hasproblem=true;
                                                }else{
                                                new_node = Object.assign({},new_node,{
                                                    isInitial:1,
                                                    shape: 'icon',
                                                    icon: {
                                                        face: 'FontAwesome',
                                                        code: '\uf193',
                                                        size: 50,
                                                        color: '#f0a30a'
                                                    }
                                                });
                                                new_node_show['isInitial'] = 1;
                                                }
                                            }
                                            if (!hasproblem) {
                                                nodes.add(new_node);
                                                nodes_show.add(new_node_show);
                                                $.alert('node ' + name + ' is added :)');
                                            }
                                        }
                                    }
                                },
                                cancel: function () {}
                            },
                            onContentReady: function () {
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click');
                                    callback(nodeData);
                                });
                            }
                        });
                    },
                    //-----------------
                    addEdge: function(edgeData,callback) {
                        var done = 0;
                        $.confirm({
                            title: 'add edge',
                            content: '<form action="" class="formName"><div class="form-group">' +
                                '<label>edge id</label><input type="text" placeholder="" class="id form-control" required autofocus><br>' +
                                '<label>symbol</label><input type="text" placeholder="" class="symbol form-control" required>' +
                                '</div>'+
                                '</form>',
                            buttons: {
                                formSubmit: {
                                    text: 'Submit',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        var id = this.$content.find('.id').val();
                                        var symbol = this.$content.find('.symbol').val();
                                        if( !id || !symbol){
                                            $.alert('please fill all fields :|');
                                            return false;}
                                        if(does_contain(edges.getIds(),id)){
                                            alert('this id is used!! :/');
                                            return false;}
                                        tmp = edges.get();
                                        isDuplicated = 0;
                                        for(tr in tmp){
                                            if(tmp[tr]['from']==edgeData['from'] && tmp[tr]['to']==edgeData['to'] && tmp[tr]['label']==edgeData['label']){
                                                alert("duplicated transition!!!    -__-");
                                                isDuplicated = 1;
                                            }
                                            if(tmp[tr]['from']==edgeData['from'] && tmp[tr]['label']==edgeData['label']){
                                                alert("duplicated transition for one symbol!!!    -__-");
                                                isDuplicated = 1;
                                            }
                                        }

                                        if(!isDuplicated){
                                            var edge_label_from='';
                                            var edge_label_to='';
                                            var nodeArray=nodes.get();
                                             for(i=0;i<nodeArray.length;i++){
                                                 if(nodeArray[i].id===edgeData.from){
                                                     edge_label_from=nodeArray[i].label;
                                                 }
                                                 if (nodeArray[i].id===edgeData.to){
                                                     edge_label_to=nodeArray[i].label;
                                                 }
                                             }
                                            edges.add({
                                                id:id,
                                                label:symbol,
                                                from:edgeData.from,
                                                to:edgeData.to,
                                                arrows:"to"
                                            });
                                            tmp=[symbol]
                                            for(i=0;i<3;i++)
                                                if(tmp[i]=="#")
                                                    tmp[i]="";
                                            edges_show.add({
                                                id:id,
                                                label:tmp[0],
                                                from:edge_label_from,
                                                to:edge_label_to
                                            });
                                        }
                                    }
                                },
                                cancel: function () {}
                            },
                            onContentReady: function () {

                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {

                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click');
                                    done = 1;
                                });
                            }
                        });
                        if(done){
                            alert('edge is added :)');
                            callback(nodeData);
                        }
                    },
                    //-----------------
                    deleteEdge: function(Data,callback){
                        edges.remove(Data['edges'][0]);
                        edges_show.remove(Data['edges'][0]);
                        callback(Data);
                    },
                    //-----------------
                    deleteNode: function(Data,callback){
                        console.log(Data);
                        for(e in Data['edges']){
                            edges.remove(Data['edges'][e]);
                            edges_show.remove(Data['edges'][e]);
                            console.log(e);
                        }
                        nodes.remove(Data['nodes'][0]);
                        nodes_show.remove(Data['nodes'][0]);
                        callback(Data);
                    }
                    //-----------------
                }
            };
            network = new vis.Network(container, data, options);
        }
        function submit(){
            if(document.getElementById("word1")===''){
                alert('please write word :)');
            } else{
            document.getElementById("sendData-transitions").value = toJSON(edges_show.get());//document.getElementById("edges").innerHTML;
            document.getElementById("sendData-states").value = toJSON(nodes_show.get());//document.getElementById("nodes").innerHTML;
            document.getElementById("word").value= document.getElementById("word1").value;
            document.getElementById("send-data").submit();
            }
        }
    </script>

</head>

<body onload="draw();">

<h2 class="text2">Find substring with the largest length that accept dfa</h2>
<div id="network"></div>
<h4 class="text2">Word:<h4/>
<input type="text" class="t2" name="word1" id="word1">
    <br>

    <?php
    if (isset($answer)) {
        echo '<div class="alert alert-success" role="alert"> ANSWER {';
        $i=0;
        foreach ($answer as $ans) {
            $i++;
            if(count($answer)==$i){
             echo $ans;
            }else {
                echo $ans . '  ,';
            }
        }
        echo '}</div>';
    }
    if (isset($error)){
        echo '<div class="alert alert-danger" role="alert"> ERROR {';
        echo $error;
        echo '}</div>';
    }
    ?>
<button type="button" name="button" onclick="submit();" class="submit_button">answer</button>
<form action="/" method="POST" id="send-data">
    <input type="hidden" name="transitions" id="sendData-transitions" value="">
    <input type="hidden" name="states" id="sendData-states" value="">
    <input type="hidden" name="word" id="word">
</form>
</body>
</html>
