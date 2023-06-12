<!DOCTYPE HTML>
<html lang="zh">
    <head>
        <title>Login page</title>
    </head>
    <style>
        input[type="submit"] {
            border: 0.1em solid;
            color: #fff;
            background-color: #000;
            font-size: larger;
            padding: 0.5em;
            transition: 0.5s;
        }
        input[type="submit"]:hover {
            cursor: pointer;
            color: #000;
            background-color: #fff;
            border-radius: 20%;
        }
        button {
            border: 0.1em solid;
            color: #fff;
            background-color: #000;
            font-size: larger;
            padding: 0.5em;
            transition: 0.5s;
        }
        button:hover {
            cursor: pointer;
            color: #000;
            background-color: #fff;
            border-radius: 20%;
        }
        #formArea {
            border: 0.1em solid;
            text-align: center;
            margin-left: 20%;
            margin-right: 20%;
            padding-bottom: 1%;
        }
        #errorMsg {
            color: #fff;
            background-color: #000;
            padding-top: 0.1em;
            padding-bottom: 0.1em;
        }
    </style>
    <body>
        <div id="formArea">
            <h1>LOGIN</h1>
            <p id="errorMsg"></p>
            <p>E-mail: <input type="text" placeholder="Enter your e-mail" name="email" require id="inputEmail"></p>
            <p>Password: <input type="password" placeholder="Enter your password" name="password" require id="inputPassword"></p>
            <button onclick="login()">login</button>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
        <script type=text/javascript>
            let loginComponent = {
                validate:function(data){
                    console.log(JSON.stringify(data));
                    axios.post('http://localhost:8080/login', JSON.stringify(data))
                    .then((response) => {
                        console.log(response);
                        if(response.data.msg == "success"){
                            location.href = "./todoPage";
                        }
                    })
                    .catch((error) => {
                        console.log(error.response.data.messages.error);
                        if(error.response.data.messages.error == "This data is not found."){
                            let errorMsg = document.getElementById("errorMsg");
                            errorMsg.innerHTML = "Wrong e-mail!";
                        }
                        if(error.response.data.messages.error == "Password is wrong."){
                            let errorMsg = document.getElementById("errorMsg");
                            errorMsg.innerHTML = "Wrong password!";
                        }
                    })
                }
            }

            function login(){
                let email = document.getElementById("inputEmail");
                let password = document.getElementById("inputPassword");
                let data = {
                    "email": email.value,
                    "password": password.value
                }
                loginComponent.validate(data);
            }
        </script>
    </body>
</html>