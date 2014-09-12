$(function(){
    $(document)
        .on('click', '.vote', function(e){
            e.preventDefault();
            $this = $(this);

            $.ajax(BASE_PATH + "/votes/vote", {
                data: {
                    vote: $this.data('vote'),
                    voteFor: $this.data('for'),
                    forId: $this.data('id')
                },
                dataType: "json",
                success: function(data){
                    if(data){
                        $voteCount = $this.closest('.vote-block').find('.vote_cnt');
                        $voteCount.html(Number($voteCount.html()) + $this.data('vote'));
                    }
                }
            });
        })
});