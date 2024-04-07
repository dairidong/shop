import pcaC from 'china-division/dist/pca-code.json'

export default function areaSelects({province = null, city = null, district = null}) {
    return {
        province,
        city,
        district,
        availableProvinces: pcaC.map(({code, name}) => ({code, name})),
        availableCities: [],
        availableDistricts: [],
        init() {
            this.$watch('province', (value) => {
                const selected = pcaC.find((province) => value === province.name);
                this.availableCities = selected ? selected.children : [];

                this.city = null;
                this.district = null;
                this.availableDistricts = [];
            });

            this.$watch('city', (value) => {
                if (!value) {
                    this.availableDistricts = [];
                    return;
                }

                const selectedProvince = pcaC.find((province) => this.province === province.name);
                const selectedCity = selectedProvince.children.find((city) => value === city.name);

                this.district = null;
                this.availableDistricts = selectedCity ? selectedCity.children : [];
            })
        }
    }
}
