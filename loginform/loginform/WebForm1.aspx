<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="WebForm1.aspx.cs" Inherits="loginform.WebForm1" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <link href="StyleSheet1.css" rel="stylesheet" />
    <title></title>
</head>
<body>
    <center><h1>Login Here</h1></center>
    <form id="form1" runat="server">
    <div class="Container">
        <label>Username</label>
        <input id="Text1" type="text" placeholder="Enter Your Username" required />
        <label>Password</label>
        <input id="Password1" type="password" placeholder="Enter Your Password" required/>
        <input class="button1" id="Button1" type="button" value="Signin" />
        <label>Forget</label>
       <a href="#"> password? </a>
    
    </div>
    </form>
</body>
</html>
