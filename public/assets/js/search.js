
$(document).ready(function () {
    $('#submit_recipe_search').on('click', function () {

        if ($('#url_link').val() != null || $('#url_link').val() != '') {

            $.ajax({
                type: 'POST',
                url: 'http://localhost:8888/CI/mijotons/search_url',
                data: {
                    link: $('#url_link').val()
                },
                datatype: 'JSON',
                success: function (data) {
                    if (data != null || data != '') {
                        var json = JSON.parse(data);
                        console.log(json)
                        $('.card-title').html('')
                        $('.card-title').html(json.recipe.title)

                        $('.content_ingredients').html('')
                        $('.content_ingredients').append('<h5 class="title_ingred">Les ingrédients</h5>')
                        for (const [key, value] of Object.entries(json.recipe.ingredients)) {
                            $('.content_ingredients').append(`<p>${value} ${key}</p>`)
                        }

                        $('.content_steps').html('')
                        for (const [key, value] of Object.entries(json.recipe.steps)) {
                            $('.content_steps').append(`<h5>${key}</h5><p style="font-size:13px;margin-bottom:5px">${value} </p>`)
                        }
                        $('.header-front').html('')
                        $('.header-front').html('<img style="max-width:80%;" src="' + json.recipe.image + '" width="200" />');

                        $('.flipper').fadeIn()

                        $("html, body").animate({ scrollTop: "+=680px" }, 800);


                    }
                }
            });
        }
    });
});
