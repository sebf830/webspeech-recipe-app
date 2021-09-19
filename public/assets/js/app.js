// Check if API is supported

if (
    "SpeechRecognition" in window ||
    "webkitSpeechRecognition" in window ||
    "mozSpeechRecognition" in window ||
    "msSpeechRecognition" in window
) {
    // speech recognition API supported
    var recognition = new (window.SpeechRecognition ||
        window.webkitSpeechRecognition ||
        window.mozSpeechRecognition ||
        window.msSpeechRecognition)();
    recognition.continuous = true;



    var commandList = document.getElementById('list_commands');
    commandList.innerHTML = '<li>"entrées", "plats", "desserts" ou dites le nom d\'un plat</li>'
} else {
    // speech recognition API not supported
    console.error("error");
    document.querySelector(".error").style.display = "block";
    document.querySelector(".start").style.display = "none";
}

// On recognize event
recognition.onresult = event => {
    const speechToText = event.results[event.results.length - 1][0];
    console.log(`${speechToText.transcript} - ${speechToText.confidence}`);

    let text = speechToText.transcript;
    console.log(text)

    document.querySelector(".command").innerHTML = "\'" + text + "\'";


    if (text.trim() == 'entrées' || text.trim() == 'entrée' || text.trim() == 'entree') {
        speak('La liste des  entrées')
        $('#displayCategories').fadeIn('slow')
        $('#displayResult').hide()
        $('.container').addClass('position');
        $('.title_category').html('Les entrées')
        $('.item').html('')

        $('#list_commands').html('');
        $('#list_commands').html('<li>"plats", "desserts", "descendre", "remonter" ou dites le nom d\'un plat</li>');


        $.ajax({
            type: 'POST',
            url: 'http://localhost:8888/CI/mijotons/category',
            data: {
                category: 'starters'
            },
            datatype: 'JSON',
            success: function (data) {
                var json = JSON.parse(data);
                for (element of json.category) {
                    var card = '<div class="card">' +
                        '<img src="' + element.image + '" alt="">' +
                        '<h4>' + element.dish_name + '</h4>' +
                        '</div>';
                    $('.item').append(card)
                }
            }
        });
    }
    else if (text.trim() == 'descends', text.trim() == 'descendre' || text.trim() == 'descend' || text.trim() == 'descente') {
        var category_content = document.querySelector('.title_category').textContent
        if (category_content != null || category_content != '') {
            $("html, body").animate({ scrollTop: "+=680px" }, 800);
        }
    }
    else if (text.trim() == 'remonter' || text.trim() == 'remonte' || text.trim() == 'remonté' ||
        text.trim() == 'remonteé ' || text.trim() == 'remontés' || text.trim() == 'remontées') {
        var category_content = document.querySelector('.title_category').textContent
        if (category_content != null || category_content != '') {
            $("html, body").animate({ scrollTop: "-=680px" }, 800);
        }
    }
    else if (text.trim() == 'plat' || text.trim() == 'plats') {
        speak('Les liste des plats')
        $('#displayCategories').fadeIn('slow')
        $('#displayResult').hide()
        $('.container').addClass('position');
        $('.title_category').html('Les plats')
        $('.item').html('')

        $('#list_commands').html('');
        $('#list_commands').html('<li>"entées", "desserts", "descendre", "remonter" ou dites le nom d\'un plat</li>');

        $.ajax({
            type: 'POST',
            url: 'http://localhost:8888/CI/mijotons/category',
            data: {
                category: 'main'
            },
            datatype: 'JSON',
            success: function (data) {
                var json = JSON.parse(data);
                for (element of json.category) {
                    var card = '<div class="card">' +
                        '<img src="' + element.image + '" alt="">' +
                        '<h4>' + element.dish_name + '</h4>' +
                        '</div>';
                    $('.item').append(card)
                }
            }
        });
    }
    else if (text == 'dessert' || text == 'desserts') {
        $('#displayCategories').fadeIn('slow')
        $('#displayResult').hide()
        $('.container').addClass('position');
        $('.title_category').html('Les desserts')
        $('.item').html('')

        $('#list_commands').html('');
        $('#list_commands').html('<li>"entrées", "plats", "descendre", "remonter" ou dites le nom d\'un plat</li>');
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8888/CI/mijotons/category',
            data: {
                category: 'dessert'
            },
            datatype: 'JSON',
            success: function (data) {
                var json = JSON.parse(data);
                for (element of json.category) {
                    var card = '<div class="card">' +
                        '<img src="' + element.image + '" alt="" >' +
                        '<h4>' + element.dish_name + '</h4>' +
                        '</div>';
                    $('.item').append(card)
                }
            }
        });
        speak('Les liste des desserts')

    }

    else if (text.includes('personne') || text.includes('personnes') || text.includes('person')) {
        var nombre = text.substr(0, 2)
        if (nombre != null || nombre != '') {
            var base = document.querySelector('.qty_dish').textContent

            speak(`recette pour ${nombre} personnes`)

            $('.title_ingrédient').html('')
            $('.title_ingrédient').append('Ingrédients pour <span class="qty_dish">' + nombre + '</span> personnes');

            speak(ingredients)
            $('html, body').animate({
                scrollTop: $("div.ingredient_section").offset().top
            }, 1000)

            var qty = document.querySelectorAll('.qty');
            qty.forEach(item => {
                var qty_ingredient = item.textContent
                if (qty_ingredient != '') {
                    var factor = Number(nombre) / Number(base)

                    var total = Number(qty_ingredient) * Number(factor)
                    item.innerHTML = total

                }
            });
        } else {
            speak(`je n'ai pas compris`)

        }
    }

    else if (text == 'image' || text == 'images') {
        if ($('.title_result').val() != null) {
            speak('Image')
            $('html, body').animate({
                scrollTop: $("div.displayResult").offset().top
            }, 1000)

        }
    }
    else if (text == 'détail' || text == 'détails') {
        if ($('#recipe_result').val() != null) {
            var detail = document.querySelector('#recipe_result').textContent
            speak(detail)

            $('html, body').animate({
                scrollTop: $("div.recipe_section").offset().top
            }, 1000)
        }
    }
    else if (text.includes('étape') || text.includes('étapes') || text.includes('etape') || text.includes('etapes')) {
        var step_number = text.substr(-1, 2)
        var stepElement = document.querySelector('.etape_no_' + step_number)
        var step = stepElement.textContent
        speak(step)

        $('html, body').animate({
            scrollTop: $("div.div_etape_" + step_number).offset().top
        }, 1000)

    }
    else if (text == 'ingrédient' || text == 'ingrédients') {
        if ($('.title_result').val() != null) {

            var ingredients = document.querySelector('#ingrédients_result').textContent

            speak(ingredients)
            $('html, body').animate({
                scrollTop: $("div.ingredient_section").offset().top
            }, 1000)
        }
    }
    else {
        recognition.continuous = true;

        $.ajax({
            type: 'POST',
            url: 'http://localhost:8888/CI/mijotons/search_dish',
            data: {
                value: text
            },
            datatype: 'JSON',
            success: function (data) {
                var json = JSON.parse(data);
                console.log(json);

                if (json.result.name != null) {
                    $('#displayResult').css('display', 'flex');
                    $('.container').addClass('position');
                    $('#displayCategories').hide()

                    //titre recette
                    $('.title_result').html('');
                    $('.title_result').append(json.result.name);

                    //image recette
                    $('.img_result').html('');
                    $('.img_result').append('<img class="image_reslt" src="' + json.result.image + '" width="450" height="400"/>');

                    //liste ingrédients
                    $('#ingrédients_result').html('');

                    for (element of json.result.ingredients) {
                        $('#ingrédients_result').append(element + ', ')
                    }

                    //etapes recette
                    $('#recipe_result').html('');
                    // $('#recipe_result').append(json.result.recipe);
                    for (element of json.result.steps) {
                        $('#recipe_result').append(element)
                    }

                    //titre ingrédients et quantité recette
                    $('.title_ingrédient').html('')
                    $('.title_ingrédient').append('Ingrédients pour <span class="qty_dish">' + json.result.dish_quantity + '</span> personnes');

                    // liste des commandes disponibles
                    $('#list_commands').html('<li>"Image", "Ingrédients", "Détail", "Etape (n)", "(n)personnes"</li>')

                    //annonce de loa recette
                    speak('La recette' + json.result.name + ' ');

                } else {
                    speak('je n\'ai pas compris')
                }
            }
        });
    }
}

//Declaring elements
const start = document.querySelector(".start"),
    main = document.querySelector(".container"),
    icon = document.querySelector(".fa-microphone"),
    main_nav = document.querySelector(".main_nav");


start.addEventListener("click", function () {
    // Show bot
    main.style.display = "flex";
    main_nav.style.display = "none";
    this.style.display = "none";
    $('.body').removeClass('background')
    // Start recognizing
    recognition.start();
});


// Speak function
function speak(text) {
    recognition.stop();

    let msg = new SpeechSynthesisUtterance(text);

    msg.onend = () => {
        console.log("fin de requete");
        console.log("Nouvelle requete");
        recognition.start();
    };

    window.speechSynthesis.speak(msg);
    return;
}

// Animating microphone while recording
recognition.onstart = () => {
    icon.classList.add("listening");
};
recognition.onend = () => {
    icon.classList.remove("listening");

};

