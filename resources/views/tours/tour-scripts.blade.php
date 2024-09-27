@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/introjs.css"/>
    @endpush
    @push('scripts.header')
        {{-- Intro.js license: --}}
        {{-- https://introjs.com/license/cs_live_a1WUbxTtjNY8cxNqxIecNmousdUal18yWWSzztxnmqiFkyFgbaDKf8SsMi --}}
        {{-- Docs: https://introjs.com/docs/ --}}
        <script src="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/intro.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
        <script>
            function tour(options, exit, complete) {
                (function () {
                    setTimeout(() => {
                        // https://introjs.com/docs/intro/options/
                        //https://introjs.com/example/programmatic/index.html

                        let intro = introJs();

                        // add the options object with the steps/functions above
                        intro.setOptions(options);

                        //use the intro.js built in onbeforechange function
                        intro.onbeforechange(function () {
                            // check to see if there is a function on this step
                            if (this._introItems[this._currentStep].onbeforechange) {
                                //if so, execute it.
                                this._introItems[this._currentStep].onbeforechange();
                            }
                        }).onchange(function () {  //intro.js built in onchange function
                            if (this._introItems[this._currentStep].onchange) {
                                this._introItems[this._currentStep].onchange();
                            }
                        }).onafterchange(function () {  //intro.js built in onchange function
                            if (this._introItems[this._currentStep].onafterchange) {
                                this._introItems[this._currentStep].onafterchange();
                            }
                        }).oncomplete(complete).onexit(exit).start();
                    }, 800)
                })();
            }
        </script>
    @endpush
@endonce
