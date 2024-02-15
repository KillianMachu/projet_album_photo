document.addEventListener("DOMContentLoaded", () => {
    const addPhoto = document.getElementById("add-photo")
    const form = document.querySelector("#add>.input-fields")

    const box = `<input type="text" name="titre-photo[]" required placeholder="Titre"><input type="file" name="image[]" required><input type="number" name="note[]" min="0" max="10" required placeholder="Note"><input type="text" name="tags[]" required placeholder="Les tags"><button id="remove-photo">Supprimer la photo</button>`

    // const box = `<input type="text" name="titre-photo[]" required placeholder="Titre"><input type="text" name="url[]" required placeholder="Lien de l'image"><input type="number" name="note[]" required placeholder="Note"><input type="text" name="tags[]" required placeholder="Les tags"><button id="remove-photo">Supprimer la photo</button>`

    const closeButton = document.querySelector("#photoBig>div>button")

    if (addPhoto) {
        addPhoto.addEventListener("click", (e) => {
            e.preventDefault();
            div = document.createElement("div")
            div.innerHTML=box
            form.appendChild(div)
            removePhoto()
        })
    }


    function removePhoto(){
        const photos = document.querySelectorAll("#add>.input-fields>div")
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

    document.querySelectorAll("#photoShow").forEach(element => element.addEventListener("click", (e) => {
        let photo = document.querySelector("#photoBig")
        document.querySelector("#photoBig>div>img").src=element.src
        photo.style.display = "block"
        document.querySelector("body").style.overflow = "hidden"
    }))

    if(closeButton){
        closeButton.addEventListener("click", (e) => {
            closeImg()
        })
    
        document.addEventListener("keyup", (e) => {
            if(e.code = "Escape"){
                closeImg()
            }
        })
    }
})

function closeImg(){
    let photo = document.querySelector("#photoBig")
    photo.style.display = "none"
    document.querySelector("body").style.overflow = null
}