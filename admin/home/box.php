<div class="col-lg-3 mt-1" id="box1">
    <?php include 'box1.php' ?>       
</div>

<div class="col-lg-3 mt-1" id="box2">
    <?php include 'box2.php' ?>                 
</div>

<div class="col-lg-3 mt-1" id="box3">                    
    <?php include 'box3.php' ?>
</div>

<div class="col-lg-3  mt-1">                    
    <?php include 'box4.php' ?>
</div>


<script>
  function box1() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("box1").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "box1.php", true);
    xhttp.send();
  }

  function box2() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("box2").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "box2.php", true);
    xhttp.send();
  }

  function box3() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("box3").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "box3.php", true);
    xhttp.send();
  }
  setInterval(function(){
    box1();
    box2();
    box3();
  },10000);
  window.onload;
</script>
