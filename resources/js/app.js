import { Editor } from "@tiptap/core";
import Alpine from "alpinejs";
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder'
import StarterKit from "@tiptap/starter-kit";
import Sortable from 'sortablejs/modular/sortable.core.esm.js';

document.addEventListener("alpine:init", () => {
  Alpine.data("editor", (content) => {
    let editor;
    return {
      isActive(type, opts = {}, updatedAt) {
        return editor.isActive(type, opts);
      },
      heading(level) {
        editor.chain().toggleHeading({ level: level }).focus().run();
      },
      bold() {
        editor.chain().toggleBold().focus().run();
      },
      italic() {
        editor.chain().toggleItalic().focus().run();
      },
      bulletList() {
        editor.chain().toggleBulletList().focus().run();
      },
      orderedList() {
        editor.chain().toggleOrderedList().focus().run();
      },
      link() {
        alert('link');
      },
      image() {
        alert('image');
      },
      codeBlock() {
        editor.chain().toggleCodeBlock().focus().run();
      },
      inlineCode() {
        editor.chain().toggleCode().focus().run();
      },
      blockquote() {
        editor.chain().toggleBlockquote().focus().run();
      },
      clearFormatting() {
        editor.chain().focus().clearNodes().unsetAllMarks().run();
      },
      undo() {
        editor.chain().focus().undo().run();
      },
      redo() {
        editor.chain().focus().redo().run();
      },
      updatedAt: Date.now(),
      content: content,
      init() {
        const _this = this;

        editor = new Editor({
          editorProps: {
            attributes: {
              class: 'prose prose-slate prose-sm',
            },
          },
          element: this.$refs.element,
          extensions: [
            StarterKit,
            Placeholder.configure({
              placeholder: 'Description...',
            }),
            Link.configure({
              linkOnPaste: true,
              openOnClick: false,
              autolink: true,
              protocols: ['ftp', 'mailto'],
            })
          ],
          content: _this.content,
          onCreate({ editor }) {
            _this.updatedAt = Date.now();
          },
          onUpdate({ editor }) {
            _this.updatedAt = Date.now();
            _this.content = editor.getHTML();
          },
          onSelectionUpdate({ editor }) {
            _this.updatedAt = Date.now();
          },
        });

        Livewire.on('clear-content', () => editor.commands.clearContent());
      }
    }
  })

  Alpine.data("poster", () => {
    return {
      init() {
        this.sleep(500).then(() => {
          document.getElementById('poster').style.height = `${this.$refs.wrapper.clientHeight}px`;
        });
      },
      sleep (time) {
        return new Promise((resolve) => setTimeout(resolve, time));
      }
    }
  })

  if (window.livewire !== undefined) {
    window.livewire.directive('sortable', (el, directive, component) => {
      if (directive.modifiers.length > 0) {
        return;
      }

      let options = { draggable: '[wire\\:sortable\\.item]' }

      if (el.querySelector('[wire\\:sortable\\.handle]')) {
          options.handle ='[wire\\:sortable\\.handle]'
      }

      new Sortable(el, {
          onEnd: function () {
              setTimeout(() => {
                  let items = []
                  el.querySelectorAll('[wire\\:sortable\\.item]').forEach((el, index) => {
                      items.push({ order: index + 1, value: el.getAttribute('wire:sortable.item')})
                  })
                  component.call(directive.method, items)
              }, 1)
          }
      });
    })
  }
})

window.Alpine = Alpine;

Alpine.start();
