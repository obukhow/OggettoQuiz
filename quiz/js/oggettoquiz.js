/**
 *
 * History management javascript
 * 
 */
window.onload = function(){
    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    if ( !History.enabled ) {
         // History.js is disabled for this browser.
         // This is because we can optionally choose to support HTML4 browsers or not.
    }

    // Bind to StateChange Event
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
        History.log(State.data, State.title, State.url);
    });
}

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
    this.question  = '#question';
    this.cache     = new Array();
    this.contentCached = this.contentCurrent = true;
    this.currentUrl;

    this.start = function() {
        this.currentQuestion++;
        this._afterStep();
    }

    this.finish = function(){
        alert('You finished!');
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
        this.updateContent(url);
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
                baseUrl + '/' + url,
                this.content.serialize(),
                function(response) {
                }
            );
        }
    }

    this.renderButtons = function() {
        this.buttons.hide();

        if(!this.currentQuestion) {
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

    this.updateContent = function(url) {
        var content;
        var self = this;
        if (this.getCache(url)) {
            this._update(url, this.getCache(url));
            this.contentCached = this.content.serialize();
            this.showCurtain(false);
        } else {
            $.get(
                baseUrl + '/' + url,
                function(response) {
                    self.saveCache(url, response);
                    self._update(url, response);
                    this.contentCached = this.content.serialize();
                    this.showCurtain(false);
                }.bind(this)
            );
        }
        this.currentUrl = url;
    }

    this._update = function(url, data) {
        this.content.html(data.html);
        this.changeState(data.title, url);
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

    this.showCurtain = function(isShow){
        (isShow) ? this.curtain.addClass('visible') : this.curtain.removeClass('visible');
    }

    this._init = function() {
        this.renderButtons();
    }
    this._init();
}
