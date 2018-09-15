
export var Geo =  {

    resolveLocationData(resolver, options) {

        this.nameSelector = options.nameSelector         || null;
        this.locationSelector = options.locationSelector || null;
        this.idSelector  = options.idSelector            || null;
        this.latSelector = options.latSelector           || null;
        this.lngSelector = options.lngSelector           || null;
        this.countrySelector = options.countrySelector   || null;
        this.name =  document.getElementById(this.nameSelector).value;
        this.resolver = resolver;

        this.callResolver();

        if(document.getElementById(this.nameSelector)) {

            document.getElementById(this.nameSelector).addEventListener('change', () => {

                setTimeout(() => {

                    this.name = this.name.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\s+/g, '+');
                    this.callResolver();
                }, 200);
            });
        }


    },

    callResolver() {

        this.resolver(
            this.name,
            this.locationSelector,
            this.idSelector,
            this.latSelector,
            this.lngSelector,
            this.countrySelector
        );
    }
};

