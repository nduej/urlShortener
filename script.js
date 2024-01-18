//Selecting all Required Elements

const form = document.querySelector(".wrapper form"),
  fullURL = form.querySelector("input"),
  shortenBtn = form.querySelector("button"),
  blurEffect = document.querySelector(".blur-effect"),
  popupBox = document.getElementById("popup-box"),
  form2 = popupBox.querySelector("form"),
  shortenURL = popupBox.querySelector("input"),
  saveBtn = popupBox.querySelector("button"),
  copyBtn = popupBox.querySelector(".copy-icon"),
  infoBox = popupBox.querySelector(".popup-box .info-box");

form.onsubmit = (e) => {
  e.preventDefault(); //Preventing form from submitting
};

shortenBtn.onclick = () => {
  //Start Ajax
  let xhr = new XMLHttpRequest(); //Creating xhr object
  xhr.open("POST", "php/url-control.php", true);
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      //if ajax request status is Ok/Successful
      let data = xhr.response;
      if (data.length <= 5) {
        blurEffect.style.display = "block";
        popupBox.classList.add("show");

        let domain = "localhost/urlShortener/";
        shortenURL.value = domain + data;
        copyBtn.onclick = () => {
          shortenURL.select();
          document.execCommand("copy");
        }
        form2.onsubmit = (e) => {
          e.preventDefault(); //preventing form from submitting
        }
        //Let's work on Save Button Click
        saveBtn.onclick = ()=>{
            let xhr2 = new XMLHttpRequest(); //creating xhr object
            xhr2.open("POST", "php/saveUrl.php", true);
            xhr2.onload = ()=>{
                if(xhr2.readyState == 4 && xhr2.status == 200){//if ajax request status is Ok
                    let data = xhr2.response;
                    if(data == "success"){
                        location.reload();  //reload the current page otherwise show error in info-box
                    }else{
                        infoBox.innerText = data;
                        infoBox.classList.add("error");
                    }
                }
            }
                //Let's send two data/value from Ajax to php
                let short_url = shortenURL.value;
                let hidden_url = data;
                xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr2.send("shorten_url="+short_url+"&hidden_url="+hidden_url);
        }
      } else {
        alert(data);
      }
    }
  }
  //let's send from data to php file
  let formData = new FormData(form); //Creating new FormData Object
  xhr.send(formData); //Sending form value to Php
};
