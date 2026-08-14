
class Speech {
    constructor(options) {
      // Chromium exposes these only under the webkit- prefix.
      const SpeechRecognitionCtor = window.SpeechRecognition || window.webkitSpeechRecognition;

      if (!SpeechRecognitionCtor) {
        this.supported = false;
        console.warn('Speech recognition is not supported by this browser.');
        return;
      }

      this.supported = true;
      this.recognition = new SpeechRecognitionCtor();

      // Default options
      this.options = {
        lang: 'en-US',       // Default language
        continuous: true,    // Keep recognising across pauses
        interimResults: false,
        words: []            // Optional command grammar
      };

      this.result = null;
      this.listening = false;   // whether we intend to keep listening
      this._callback = null;    // active onresult callback

      this.set(options);
      this._bindEvents();
    }

    _bindEvents() {
      const recognition = this.recognition;

      recognition.onresult = (event) => {
        this.result = event.results[event.results.length - 1][0].transcript;
        if (this._callback) {
          this._callback({
            listen: (cb) => this.listen(cb),
            vocal: this.result,
            stop: () => this.stop(),
          });
        }
      };

      recognition.onerror = (event) => {
        // Fatal permission errors: stop the auto-restart loop so we don't spin.
        if (event.error === 'not-allowed' || event.error === 'service-not-allowed') {
          this.listening = false;
          console.warn('Speech recognition permission denied:', event.error);
        } else if (event.error !== 'no-speech' && event.error !== 'aborted') {
          // 'no-speech' / 'aborted' are normal during pauses; surface the rest.
          console.warn('Speech recognition error:', event.error);
        }
      };

      recognition.onend = () => {
        // The engine ends on its own (timeout, single result, error).
        // Restart only while the caller still wants to listen.
        if (this.listening) {
          try { recognition.start(); } catch (e) { /* already starting */ }
        }
      };
    }

    listen(callback) {
      if (!this.recognition) return this;
      if (callback) this._callback = callback;
      this.listening = true;
      try {
        this.recognition.start();
      } catch (e) {
        // start() throws if recognition is already running — safe to ignore.
      }
      return this;
    }

    stop() {
      if (!this.recognition) return this;
      this.listening = false; // prevent onend from restarting
      this.recognition.stop();
      return this;
    }

    set(options) {
      if (!options || !this.recognition) return this;

      this.options = { ...this.options, ...options };

      if (options.lang) this.recognition.lang = options.lang;
      if ('continuous' in options) this.recognition.continuous = options.continuous;
      if ('interimResults' in options) this.recognition.interimResults = options.interimResults;

      // Optional command grammar (JSGF). Deprecated/ignored by some engines,
      // so it is applied only when a grammar list constructor exists.
      if (options.words && options.words.length) {
        const GrammarListCtor = window.SpeechGrammarList || window.webkitSpeechGrammarList;
        if (GrammarListCtor) {
          const commands = options.words.map(word => `"${word}"`).join(' | ');
          const grammar = `#JSGF V1.0; grammar commands; public <command> = ${commands};`;
          const list = new GrammarListCtor();
          list.addFromString(grammar, 1);
          this.recognition.grammars = list;
        }
        // else: grammar lists unsupported here — safely ignored.
      }

      return this;
    }
  }

  // // Example usage — requires a secure context (HTTPS or localhost) and
  // // microphone permission. Best triggered from a user gesture (e.g. a click).
  // const speech = new Speech({
  //   lang: 'en-US',
  //   continuous: true,
  //   words: ['on', 'off']
  // });

  // // Example of listening
  // speech.listen((s) => {
  //   console.log('Heard:', s.vocal);
  //   // s.stop();            // stop listening
  //   // s.listen(cb);        // (re)start with a new callback
  // });
