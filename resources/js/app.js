import { Editor } from "@tiptap/core";
import Alpine from "alpinejs";
import Link from '@tiptap/extension-link';
import StarterKit from "@tiptap/starter-kit";
import FloatingMenu from '@tiptap/extension-floating-menu'

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
            FloatingMenu.configure({
              element: document.querySelector('.tiptap-float'),
              shouldShow: ({ editor }) => {
                return editor.getJSON().content.length > 1 ? true : false
              }
            }),
            Link.configure({
              linkOnPaste: true,
              openOnClick: false,
              autolink: true,
              protocols: ['ftp', 'mailto'],
            }),
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
})

window.Alpine = Alpine;

Alpine.start();
