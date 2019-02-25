<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="tabs">

       <div class="tab">
           <input type="radio" id="tab-1" name="tab-group-1" checked>
           <label for="tab-1">Login</label>

           <div class="content">
               <form class="" action="index.html" method="post">
                 <input type="text" name="username"  placeholder="username">
                 <input type="password" name="password"  placeholder="password">
                 <button type="login" name="button">Login</button>
               </form>
           </div>
       </div>

       <div class="tab">
           <input type="radio" id="tab-2" name="tab-group-1">
           <label for="tab-2">Register</label>

           <div class="content">
             <form class="" action="index.html" method="post">
               <input type="text" name="username"  placeholder="username">
               <input type="password" name="password"  placeholder="password">
               <input type="password" name="repassword"  placeholder="repeat password">
               <input type="email" name="email"  placeholder="email">
               <input type="text" name="firsntname" placeholder="first name">
               <input type="text" name="lastname" placeholder="last name">
               <button type="login" name="button">Register</button>
             </form>
           </div>
       </div>

    </div>
  </body>
</html>
