/**
 *
 * History management javascript
 * 
 */

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

function OggettoQuiz(questionsCount, currentQuestion, baseUrl)
{
    this.count     = questionsCount;
    this.baseUrl   = baseUrl; 
    this.currentQuestion = (currentQuestion) ? currentQuestion : 0;
    this.startBtn  = $('#startBtn');
    this.prevBtn   = $('#prevBtn');
    this.nextBtn   = $('#nextBtn');
    this.finishBtn = $('#finishBtn');
    this.content   = $('#page-content');
    this.question  = '#question';
    this.cache     = new Array;
    this.currentUrl;

    this.start = function() {
        this.currentQuestion++;
        this._afterStep();
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
        if (this.getCache(this.currentUrl)) {
            var cache = this.getCache(this.currentUrl);
            cache.html = this.cloneContent();
            this.saveCache(this.currentUrl, cache);
        }
        this.saveQuestion();
    }

    this._afterStep = function() {
        this.renderButtons();
        url = "question/" + this.currentQuestion;
        this.updateContent(url);
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

    this.saveQuestion = function() {
        contentCurrent = this.content.serialize();
        if(contentCached !== contentCurrent) {
            $.post(
                baseUrl + '/' + url,
                this.content.serialize(),
                function(response) {
                }
            );
        }
    }

    this.renderButtons = function() {
        if (this.currentQuestion == this.count) {
            this.finishBtn.show();
            this.nextBtn.hide();
            this.prevBtn.show();
        } else if (this.currentQuestion < this.count) {
            this.finishBtn.hide();
            this.nextBtn.show();
            this.prevBtn.show();
        } 
        if (!this.currentQuestion) {
            this.startBtn.show();
            this.prevBtn.hide();
            this.nextBtn.hide();
        } else {
            this.startBtn.hide();
        }
    }

    this.updateContent = function(url) {
        var content;
        var self = this;
        if (this.getCache(url)) {
            this._update(url, this.getCache(url));
            contentCached = this.content.serialize();
        } else {
            $.get(
                baseUrl + '/' + url,
                function(response) {
                    self.saveCache(url, response);
                    self._update(url, response);
                    contentCached = this.content.serialize();
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

    this._init = function() {
        this.renderButtons();
    }
    this._init();
}
