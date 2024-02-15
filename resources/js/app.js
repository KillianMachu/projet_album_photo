// import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {
    const addPhoto = document.getElementById("add-photo")
    const form = document.querySelector("#add>.create-container>.input-fields")

    const box = `<input type="text" name="titre-photo[]" required placeholder="Titre"><input type="file" name="image[]" required><input type="number" name="note[]" min="0" max="5" required placeholder="Note"><input type="text" name="tags[]" required placeholder="Les tags"><i class='bx bx-x' id="remove-photo"></i>`

    const closeButton = document.querySelector("#photoBig>button")

    const showCreateForm = document.getElementById("showCreateForm")

    const createForm = document.getElementById("createForm")

    const closeCreateForm = document.getElementById("closeCreateForm")

    // affichage du formulaire d'ajout de photo dans show

    if(showCreateForm && createForm) {
        showCreateForm.addEventListener("click", () => {
            createForm.style.display="block"
            document.querySelector("body").style.overflow = "hidden"
        })
    }

    if(closeCreateForm){
        closeCreateForm.addEventListener("click", (e) => {
            closeCreateFormFunc()
        })
    
        document.addEventListener("keyup", (e) => {
            if(e.code == "Escape"){
                closeCreateFormFunc()
            }
        })
    }

    function closeCreateFormFunc(){
        createForm.style.display = "none"
        document.querySelector("body").style.overflow = null
    }

    // ajouter une entrée de photo dans le formulaire

    if (addPhoto) {
        addPhoto.addEventListener("click", (e) => {
            e.preventDefault();
            let div = document.createElement("div")
            div.innerHTML=box
            form.appendChild(div)
            removePhoto()
        })
    }

    // supprimer une entrée de photo dans le formulaire

    function removePhoto(){
        const photos = document.querySelectorAll("#add>.create-container>.input-fields>div")
        if (photos) {
            photos.forEach(photo => {
                photo.querySelector("#remove-photo").addEventListener("click", (e) => {
                    e.preventDefault();
                    photo.remove()
                })
            })
        }
    }
    removePhoto()

    // afficher la photo en grand

    document.querySelectorAll("#photoShow").forEach(element => element.addEventListener("click", (e) => {
        let photo = document.querySelector("#photoBig")
        document.querySelector("#photoBig>div>img").src=element.src
        photo.style.display = "block"
        document.querySelector("body").style.overflow = "hidden"
    }))

    // fermer la photo

    if(closeButton){
        closeButton.addEventListener("click", (e) => {
            closeImg()
        })
    
        document.addEventListener("keyup", (e) => {
            if(e.code == "Escape"){
                closeImg()
            }
        })
    }

    function closeImg(){
        let photo = document.querySelector("#photoBig")
        photo.style.display = "none"
        document.querySelector("body").style.overflow = null
    }


    // fermer les infos et disparition automatique
    
    let close_info=document.querySelector("#close_info")
    let info = document.querySelector("#info")
    
    function funcCloseInfo(){
        info.style.opacity= "0"
            setTimeout(() => {
                info.remove()
            }, 500);
    }
    
    if(close_info && info){
        close_info.addEventListener("click", (e) => {
            funcCloseInfo()
        })
    
        setTimeout(() => {
            funcCloseInfo()
        }, 5000);
    }

    // hauteur vidéo welcome
    
    let headerHeight = document.querySelector('header').offsetHeight;
    
    let home_video = document.querySelector('#home_video')
    
    function homeVideoHeight(){
        home_video.style.height = "calc(100vh - " + headerHeight + "px)"
    }
    
    if(home_video){
        window.addEventListener("resize", homeVideoHeight)
        window.addEventListener("load", homeVideoHeight)
    }
})
