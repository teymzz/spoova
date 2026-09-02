class SSRegistry {

  static #originals = new WeakMap();
  static #loaded = false;

  static init(context = document) {
    if(this.#loaded) return;
    const allElements = context.querySelectorAll('*');
    const dataElements = Array.from(allElements).filter(el =>
      Array.from(el.attributes).some(attr => attr.name.startsWith('data-'))
    );

    dataElements.forEach(el => {
      if (!this.#originals.has(el)) {
        const dataset = {};
        for (const attr of el.attributes) {
          if (attr.name.startsWith('data-')) {
            const camelKey = this.#toCamel(attr.name.slice(5));
            dataset[camelKey] = this.#parse(attr.value);
          }
        }
        this.#originals.set(el, Object.freeze({ ...dataset }));
        this.#loaded = true;
      }
    });
  }

  static get(el) {
    return this.#originals.get(el) || {};
  }

  static #parse(val) {
    if (val === "true") return true;
    if (val === "false") return false;
    if (val === "null") return null;
    if (val === "undefined") return undefined;
    if (!isNaN(val) && val.trim() !== "") return Number(val);
    return val;
  }

  static #toCamel(str) {
    return str.replace(/-([a-z])/g, (_, c) => c.toUpperCase());
  }
}

SSRegistry.init();

export default SSRegistry;