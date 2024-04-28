
<div class="container">
<div class="card">
  <div class="card-image">
    <img src="https://images.unsplash.com/photo-1604135307399-86c6ce0aba8e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1374&q=80">
  </div>
  <div class="card-text">
    <p class="card-meal-type">Breakfast/Eggs</p>
    <h2 class="card-title">Délicieux Bénédicte</h2>
    <p class="card-body">Eggs Benedict with hollandaise sauce, crispy bacon and an assortment of garden herbs.</p>
  </div>
  <div class="card-price">$56</div>
</div>
  <div class="card">
  <div class="card-image">
    <img src="https://images.unsplash.com/photo-1551782450-17144efb9c50?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1769&q=80">
  </div>
  <div class="card-text">
    <p class="card-meal-type">Lunch/Meat</p>
    <h2 class="card-title">Du bœuf Burger</h2>
    <p class="card-body">A beef burger with wholewheat patty, juicy lettuce and a side of gluten free fries</p>
  </div>
  <div class="card-price">$39</div>
</div>
  <div class="card">
  <div class="card-image">
    <img src="https://images.unsplash.com/photo-1635146037526-a75e6905ad78?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1834&q=80">
  </div>
  <div class="card-text">
    <p class="card-meal-type">Soups/Meat</p>
    <h2 class="card-title">Soupe à l’oignon</h2>
    <p class="card-body">The traditional French soup made with onions and beef with a dollop of garlic and saffaron mayonise.</p>
  </div>
  <div class="card-price">$69</div>
</div>
  <div class="card">
  <div class="card-image">
    <img src="https://www.expatica.com/app/uploads/sites/5/2020/03/Coq-au-vin.jpg">
  </div>
  <div class="card-text">
    <p class="card-meal-type">Appetizers/Meat</p>
    <h2 class="card-title">Coq au Vin</h2>
    <p class="card-body">Chickens doused in wine, mushrooms, pork, onions and garlic.</p>
  </div>
  <div class="card-price">$104</div>
</div>

</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,900;1,400;1,900&display=swap');
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Playfair Display', serif;
}
body{ background:url(https://images.unsplash.com/photo-1495195129352-aeb325a55b65?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1776&q=80);
  background-size:cover;
  background-position:right;
  background-attachment:fixed;
}
#header{
  margin:20px;
}
#header>h1{
  text-align:center;
  font-size:3rem;
}
#header>p{
  text-align:center;
  font-size:1.5rem;
  font-style:italic;
}
.container{
  width:100vw;
  display:flex;
  justify-content:space-around;
  flex-wrap:wrap;
  padding:40px 20px;
}
.card{
  display:flex;
  flex-direction:column;
  width:400px;
  margin-bottom:60px;
}
.card>div{
  box-shadow:0 15px 20px 0 rgba(0,0,0,0.5);
}
.card-image{
  width:400px;
  height:250px;
}
.card-image>img{
  width:100%;
  height:100%;
  object-fit:cover;
  object-position:bottom;
}
.card-text{
  margin:-30px auto;
  margin-bottom:-50px;
  height:300px;
  width:300px;
  background-color:#1D1C20;
  color:#fff;
  padding:20px;
}
.card-meal-type{
  font-style:italic;
}
.card-title{
  font-size:2.2rem;
  margin-bottom:20px;
  margin-top:5px;
}
.card-body{
  font-size:1.25rem;
}
.card-price{
  width:100px;
  height:100px;
  background-color:#970C0A;
  color:#fff;
  margin-left:auto;
  font-size:2rem;
  display:flex;
  justify-content:center;
  align-items:center;
}

</style>