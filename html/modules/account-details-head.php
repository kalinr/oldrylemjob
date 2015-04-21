<script type="text/javascript">
    //used on the wholesale app and myaccount-details page
  window.onload = function(e) {
      document.getElementById("myform").addEventListener('submit', function (e) {
          if(document.getElementsByName("EMAIL2")[0].value == ""){
              //allow submission if nothing is entered
              return true;
          }else{
              if(confirm("Additional emails will have access to your account. Are you sure you trust all the emails you have entered?")){
                  //allow submission if user says it's okay
                  return true;
              }else{
                  //prevent submission if user says no
                  e.preventDefault();
                  return false;
              }
          }
      }, false);
  }

</script>