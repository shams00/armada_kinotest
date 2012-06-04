var movie = {

    initRating:function ()
    {
        $('#rating_date').datepicker({
            'dateFormat':'yy-mm-dd',
            'onSelect':function (dateText)
            {
                movie.loadRating(dateText);
            }
        });
    },

    loadRating:function (date)
    {
        $('#rating_container').load(
            Routing.generate('ArmadaMovieBundle_homepage'),
            {'date':date, 'ajax': 1}
        );
    }

};