document.addEventListener('DOMContentLoaded', () => {
    (async() => {
        while(!window.hasOwnProperty("memes"))
            await new Promise(resolve => setTimeout(resolve, 1000));
        var select = document.getElementById('meme-selector');
        var boxContainer = document.getElementById('box-container');
        var requestToken = document.getElementById('requestToken').value;
        var memeAlert = document.getElementById('meme-alert');

        generateMemeTextBoxes();
        updateTemplateLink();

        document.getElementsByClassName('btn-meme-alert')[0].addEventListener('click', () => {
            memeAlert.style.display = 'none';
        }, false);

        select.addEventListener('change', () => {
            generateMemeTextBoxes();
            updateTemplateLink();
        }, false);
        document.getElementById('sendMeme').addEventListener('click', generateMeme);

        /**
         * this function changes the count of text boxes
         */
        function generateMemeTextBoxes() {
            if(boxContainer.children.length > 0) {
                boxContainer.replaceChildren();
            }
            let meme = memes[select.selectedIndex];
            for (var i=0; i<meme.box_count; i++) {
                addBoxToContainer();
            }
        }

        /**
         * this function updates the template link
         */
        function updateTemplateLink() {
            document.getElementById('show-template').href = memes[select.selectedIndex].url;
        }

        /**
         * this function adds boxes to the container
         */
        function addBoxToContainer() {
            var box = document.createElement('input');
            box.classList.add('form-control');
            box.placeholder = 'enter meme text';
            boxContainer.appendChild(box);
        }

        /**
         * this function returns the meme data for generation
         * @returns {*[]}
         */
        function getMemeData() {
            let selectedMeme = document.getElementById('meme-selector').value
            let memeData = [];
            memeData.boxes = [];

            for (var i=0; i<boxContainer.children.length; i++) {
                memeData['boxes'][i] = {'text': boxContainer.children[i].value}
            }
            memeData['id'] = selectedMeme;
            return memeData;
        }

        /**
         * this function makes the api call and creates the meme
         */
        function generateMeme() {
            let memeData = getMemeData();

            fetch('/contao/agonyz/generate-meme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: "data="+ JSON.stringify(Object.assign({}, memeData)) +"&REQUEST_TOKEN="+requestToken,
            })
                .then(response => response.json())
                .then(response => {
                    if(response.data.success === true) {
                        document.getElementById('meme-image').src = response.data.data.url;
                        document.getElementById('meme-image').style.display = 'block';
                    }
                    else {
                        memeAlert.style.display = 'block';
                        document.getElementById('error-info').innerText = response.data.error_message;
                    }
                })
        }
    })();
}, false);