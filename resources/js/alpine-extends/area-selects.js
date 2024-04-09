import pcaC from 'china-division/dist/pca-code.json'

export default function areaSelects() {
    return {
        province: null,
        city: null,
        district: null,
        availableProvinces: pcaC.map(({code, name}) => ({code, name})),
        availableCities: [],
        availableDistricts: [],
        provinceSelect: {
            ['x-modelable']: 'province',
        },
        citySelect: {
            ['x-modelable']: 'city',
        },
        districtSelect: {
            ['x-modelable']: 'district',
        },
        init() {
            this.$watch('province', (value) => {
                const selected = pcaC.find((province) => value === province.name);
                this.availableCities = selected ? selected.children : [];

                // For edit init
                const city = this.availableCities.find((city) => city.name === this.city);
                if (!city) {
                    this.city = null;
                }
            });

            this.$watch('city', (value) => {
                if (!value) {
                    this.district = null;
                    this.availableDistricts = [];
                    return;
                }

                const selectedProvince = pcaC.find((province) => this.province === province.name);
                const selectedCity = selectedProvince.children.find((city) => value === city.name);

                const district = selectedCity.children.find((district) => district.name === this.district);
                if (!district) {
                    this.district = null;
                }
                this.availableDistricts = selectedCity ? selectedCity.children : [];
            });
        }
    }
}
