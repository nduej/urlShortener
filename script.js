//Selecting all Required Elements

const form = document.querySelector(".wrapper form"),
fullURL = form.querySelector("input"),
shortenBtn  = form.querySelector("button"),
blurEffect  = document.querySelector(".blur-effect"),
popupBox  = document.querySelector(".popup-box"),
shortenURL  = popupBox.querySelector("input");


form.onsubmit = (e)=>{
    e.preventDefault(); //Preventing form from submitting
}

shortenBtn.onclick = ()=>{
    //Start Ajax
    let xhr = new XMLHttpRequest(); //Creating xhr object
    xhr.open("POST", "php/url-control.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){ //if ajax request status is Ok/Successful
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");
                

                let domain = "localhost/url/?u=";
                shortenURL.value = domain + data;
            }else{
                alert(data);
            }
        }
    }
    //let's send from data to php file
    let formData = new FormData(form); //Creating new FormData Object
    xhr.send(formData); //Sending form value to Php
}