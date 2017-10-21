<div id="essayEditor">
    <div class="logged-in-remove" style="display: none; background: #c73131; padding: 10px; color: white;">
      Remember! This is just the test editor. To start writing your essay and have it autosave, <strong><a style="cursor: pointer;" onclick="window.modal('Login_Register'); event.preventDefault();">register or login</a></strong> and save!
    </div>
    <div class="error-area" style="display: none; background: #c73131; padding: 10px; font-size: 14px; color: white;"></div>

    <div id="title" tabindex="0" class="title" data-selected="title" contenteditable="true">
      <div class="titler titler-title" data-for="title" contenteditable="false" readonly>TITLE</div>
      <div class="INTERNAL"></div>
    </div>

    <div id="introduction" tabindex="0" class="introduction" data-selected="introduction" contenteditable="true">
      <div class="titler titler-introduction" data-for="introduction" contenteditable="false" readonly>INTRODUCTION</div>
      <div class="INTERNAL"></div>
    </div>

    <div id="paragraphs" contenteditable="true">
      <div class="titler titler-paragraph" data-for="paragraphs" contenteditable="false" readonly>PARAGRAPHS (<span id="paragraphnumber"></span>)</div>
      <div class="paragraph p1" tabindex="0" data-selected="paragraph" data-paragraph="1">

      </div>
      <div class="paragraph p2" tabindex="0" data-selected="paragraph" data-paragraph="2">

      </div>
    </div>

    <div id="conclusion" class="conclusion" data-selected="conclusion" tabindex="0" contenteditable="true">
      <div class="titler titler-conclusion" data-for="conclusion" contenteditable="false" readonly>CONCLUSION</div>
      <div class="INTERNAL"></div>
    </div>
</div>
