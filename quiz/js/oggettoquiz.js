/**
 *
 * History management javascript
 * 
 */
$(window).load(function () {
    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    if ( !History.enabled ) {
         // History.js is disabled for this browser.
         // This is because we can optionally choose to support HTML4 browsers or not.
    }

    // Bind to StateChange Event
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
        var key = 'question/' + State.data.state;

        // History.log(State.data, State.title, State.url);

        if(quiz.getCache(key)) {
            quiz.updateContentHistory(key, quiz.getCache(key));
        }
    });

});

function OggettoQuiz(questionsCount, currentQuestion, baseUrl)
{
    this.count     = questionsCount;
    this.baseUrl   = baseUrl;
    this.currentQuestion = (currentQuestion) ? currentQuestion : 0;
    this.buttons   = $('.btn');
    this.startBtn  = $('#startBtn');
    this.prevBtn   = $('#prevBtn');
    this.nextBtn   = $('#nextBtn');
    this.finishBtn = $('#finishBtn');
    this.content   = $('#page-content');
    this.curtain   = $('#curtain');
    this.counter   = $('#counter');
    this.question  = '#question';
    this.cache     = new Array();
    this.contentCached = this.contentCurrent = true;
    this.currentUrl;
    this.manualUpdate = false;

    this.start = function() {
        this.currentQuestion++;
        this._afterStep();
    }

    this.finish = function(){
        if (confirm('Are you shure you want to finish?')) {
            this._beforeStep();
            document.location.href = this.baseUrl + '/success';
        }
    }

    this.next = function() {
        this._beforeStep();
        this.currentQuestion++;
        this._afterStep();
    }

    this.previous = function() {
        this._beforeStep();
        this.currentQuestion--;
        this._afterStep();
    }

    this._beforeStep = function() {
        this.showCurtain(true);
        if (this.getCache(this.currentUrl)) {
            var cache = this.getCache(this.currentUrl);
            cache.html = this.cloneContent();
            this.saveCache(this.currentUrl, cache);
        }
        this.saveQuestion(this.currentUrl);
    }

    this._afterStep = function() {
        url = "question/" + this.currentQuestion;
        this.updateContent(url, false);
        this.renderButtons();
    }

    this.cloneContent = function(){
        var original = $(this.question);
        var cloned = original.clone();

        var originalElems = original.find('select, textarea');
        cloned.find('select, textarea').each(function(index, item) {
            //set new element to value of old element
            $(item).val( originalElems.eq(index).val() );
        });

        return cloned;
    }

    this.saveQuestion = function(url) {
        if(!url) {
            url = 'question/' + this.currentQuestion;
            var cache = {};
            cache.html = this.cloneContent();
            this.saveCache(url, cache);
        }
        this.contentCurrent = this.content.serialize();

        if(this.contentCached !== this.contentCurrent) {
            $.post(
                baseUrl + '/postQuestion',
                this.content.serialize(),
                function(response) {
                }
            );
        }
    }

    this.renderButtons = function() {
        this.buttons.hide();
        this.renderCounter();

        if(!this.currentQuestion) {
            this.counter.hide();
            this.startBtn.show();
            return;
        }

        if(this.currentQuestion == this.count) {
            this.prevBtn.show();
            this.finishBtn.show();
            return;
        }

        if(this.currentQuestion > 0) {
            this.nextBtn.show();
        }
        if (this.currentQuestion > 1) {
            this.prevBtn.show();
        }
    }

    this.updateContent = function(url, isHistory) {
        var content;
        var self = this;
        
        if (this.getCache(url)) {
            this._update(url, this.getCache(url), isHistory);
            this.contentCached = this.content.serialize();
            this.showCurtain(false);
        } else {
            $.get(
                baseUrl + '/ajax' + url + '?t=' + new Date().getTime(),
                function(response) {
                    self.saveCache(url, response);
                    self._update(url, response, isHistory);
                    this.contentCached = this.content.serialize();
                    this.showCurtain(false);
                }.bind(this)
            );
        }
        this.currentUrl = url;
    }

    this.updateContentHistory = function(url, data) {
        if (this.manualUpdate) {
            return;
        }
        this.saveQuestion(url);
        
        this.currentQuestion = History.getState().data.state;
        this.currentUrl = url;
        this.renderButtons();

        this.content.html(data.html);
        this.contentCached = this.content.serialize();
    }

    this._update = function(url, data, isHistory) {
        this.content.html(data.html);
        if(!isHistory) {
            this.manualUpdate = true;
            this.replaceState(data.title, url);
            this.manualUpdate = false;
        }
    }

    this.saveCache = function (key, value) {
        this.cache[key] = value;
    }

    this.getCache = function(key) {
        if (this.cache[key] === 'undefined') {
            return false;
        }
        return this.cache[key];
    }

    this.changeState = function(title, url) {
        History.pushState({state: this.currentQuestion}, title, baseUrl + '/' + url);
    }

    this.replaceState = function(title, url) {
        History.replaceState({state: this.currentQuestion}, title, baseUrl + '/' + url);
    }

    this.showCurtain = function(isShow){
        (isShow) ? this.curtain.addClass('visible') : this.curtain.removeClass('visible');
    }

    this.renderCounter = function(){
        this.counter.show().find('#counter-current').html(this.currentQuestion);
    }

    this._init = function() {
        this.renderButtons();
    }
    this._init();
}
