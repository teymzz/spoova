import { SPAuto } from "./autoload/SPAuto.js";

class ItemDragger {
    constructor() {
        this.switchElements = [];
        this.parentElements = [];
        this.offsets = new Map();
        this.isDragging = false;
        this.callbacks = {};
        this.dragCounts = new Map();
    }

    select(switchSelector, parentSelector) {
        this.switchElements = document.querySelectorAll(switchSelector);
        this.parentElements = document.querySelectorAll(parentSelector);
        if (!this.switchElements.length || !this.parentElements.length) {
            throw new Error("Invalid selector: Ensure both elements exist.");
        }
        return this;
    }

    drag(callback) {
        this.callbacks = {
            started: () => {},
            isDragging: () => {},
            dropped: () => {},
        };
        
        if (typeof callback === "function") {
            callback({
                started: (fn) => (this.callbacks.started = fn),
                isDragging: (fn) => (this.callbacks.isDragging = fn),
                dropped: (fn) => (this.callbacks.dropped = fn),
            });
        }
        
        this.switchElements.forEach((switchElement, index) => {
            switchElement.style.cursor = "grab";
            switchElement.addEventListener("mousedown", (event) => this.startDrag(event, index));
        });
        document.addEventListener("mousemove", this.onDrag.bind(this));
        document.addEventListener("mouseup", this.stopDrag.bind(this));
    }

    startDrag(event, index) {
        this.isDragging = true;
        const parentElement = this.parentElements[index];
        const dragCount = (this.dragCounts.get(parentElement) || 0) + 1;
        this.dragCounts.set(parentElement, dragCount);

        this.offsets.set(index, {
            x: event.clientX,
            y: event.clientY,
            startLeft: parseInt(getComputedStyle(parentElement).left) || 0,
            startTop: parseInt(getComputedStyle(parentElement).top) || 0,
        });
        this.switchElements[index].style.cursor = "grabbing";
        this.callbacks.started(parentElement, dragCount);
    }

    onDrag(event) {
        if (!this.isDragging) return;
        this.parentElements.forEach((parentElement, index) => {
            if (this.offsets.has(index)) {
                const offset = this.offsets.get(index);
                const newLeft = offset.startLeft + (event.clientX - offset.x);
                const newTop = offset.startTop + (event.clientY - offset.y);
                
                // Ensure the element stays within screen bounds
                const maxLeft = window.innerWidth - parentElement.offsetWidth;
                const maxTop = window.innerHeight - parentElement.offsetHeight;
                
                parentElement.style.position = "absolute";
                parentElement.style.left = `${Math.max(0, Math.min(newLeft, maxLeft))}px`;
                parentElement.style.top = `${Math.max(0, Math.min(newTop, maxTop))}px`;
                
                this.callbacks.isDragging(parentElement);
            }
        });
    }

    stopDrag() {
        this.isDragging = false;
        this.switchElements.forEach((switchElement) => switchElement.style.cursor = "grab");
        this.parentElements.forEach((parentElement) => this.callbacks.dropped(parentElement));
        this.offsets.clear();
    }
}

export default SPAuto(ItemDragger);

//* Example usage:...........................................................

// ss.itemDragger().select('.switch', '.parent').drag(function(callback) {
//     callback.started((element, dragCount) => console.log("Drag started on:", element, "Drag count:", dragCount));
//     callback.isDragging((element) => console.log("Dragging:", element));
//     callback.dropped((element) => console.log("Dropped:", element));
// }); 
