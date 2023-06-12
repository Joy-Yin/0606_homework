<!DOCTYPE html>
<html lang="zh">
<head>
    <title>TodoList</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type=text/javascript>
        $(document).ready(function(){
            // todoComponent.delete(7);
            console.log("Hi");
        });

        let todoComponent = {
            index: function(){
                axios.get('http://localhost:8080/todo')
                .then((response) => {
                    console.log(response);
                    if(response.data.msg == "success"){
                        let resultArea = document.getElementById("resultArea");
                        let result = `
                        <table border="1" cellpadding="10" style="border-collapse: collapse;">
                            <thead>
                                <th>key</th>
                                <th>title</th>
                                <th>content</th>
                                <th>created at</th>
                                <th>updated at</th>
                            </thead>
                            <tbody>
                        `;
                        for(let element of response.data.data){
                            result+="<tr><td>";
                            result+=element.t_key;
                            result+="</td><td>";
                            result+=element.t_title;
                            result+="</td><td>";
                            result+=element.t_content;
                            result+="</td><td>";
                            result+=element.created_at;
                            result+="</td><td>";
                            result+=element.updated_at;
                            result+="</td></tr>";
                        }
                        result+="</tbody></table>";
                        resultArea.innerHTML = result;
                    }
                })
                .catch((error) => console.log(error.response.data.messages.error))
            },
            show: function(key){
                axios.get('http://localhost:8080/todo/' + key)
                .then((response) => {
                    console.log(response);
                    if(response.data.msg == "success"){
                        let resultArea = document.getElementById("resultArea");
                        let result = `
                        <table border="1" cellpadding="10" style="border-collapse: collapse;">
                            <thead>
                                <th>key</th>
                                <th>title</th>
                                <th>content</th>
                                <th>created at</th>
                                <th>updated at</th>
                            </thead>
                            <tbody>
                        `;
                        let element = response.data.data;
                        result+="<tr><td>";
                        result+=element.t_key;
                        result+="</td><td>";
                        result+=element.t_title;
                        result+="</td><td>";
                        result+=element.t_content;
                        result+="</td><td>";
                        result+=element.created_at;
                        result+="</td><td>";
                        result+=element.updated_at;
                        result+="</td></tr></tbody></table>";
                        resultArea.innerHTML = result;
                    }
                })
                .catch((error) => console.log(error.response.data.messages.error))
            },
            create: function(data){
                axios.post('http://localhost:8080/todo', JSON.stringify(data))
                .then((response) => console.log(response))
                .catch((error) => console.log(error.response.data.messages.error))
            },
            update: function(data, key){
                axios.put('http://localhost:8080/todo/' + key, JSON.stringify(data))
                .then((response) => console.log(response))
                .catch((error) => console.log(error.response.data.messages.error))
            },
            delete: function(key){
                axios.delete('http://localhost:8080/todo/' + key)
                .then((response) => console.log(response))
                .catch((error) => console.log(error.response.data.messages.error))
            },
        }
    </script>
</head>
<body>
    <div>
        <h1>TodoList:</h1>
        <p>input key:<input type="text" id="keyName"></p>
        <p>input new title:<input type="text" id="titleName"></p>
        <p>input new content:<input type="text" id="contentName"></p>
        <button onclick="showOneData()">show</button>
        <button onclick="todoComponent.index()">show all</button>
        <button onclick="createTodo()">create</button>
        <button onclick="updateTodo()">update</button>
        <button onclick="deleteTodo()">delete</button>
    </div>
    <div id="resultArea" style="margin-top: 3%">

    </div>
    <script>
        function showOneData(){
            let key = document.getElementById("keyName");
            todoComponent.show(key.value);
        }
        function createTodo(){
            let title = document.getElementById("titleName");
            let content = document.getElementById("contentName");
            let data = {
                "title": title.value,
                "content": content.value
            };
            console.log(data);
            todoComponent.create(data);
            todoComponent.index();
        }
        function updateTodo(){
            let key = document.getElementById("keyName");
            let title = document.getElementById("titleName");
            let content = document.getElementById("contentName");
            let data = {
                "title": title.value,
                "content": content.value
            };
            todoComponent.update(data, key.value);
            todoComponent.index();
        }
        function deleteTodo(){
            let key = document.getElementById("keyName");
            todoComponent.delete(key.value);
            todoComponent.index();
        }
    </script>
</body>
</html>