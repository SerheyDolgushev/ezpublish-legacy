<form action={concat("content/exportpdf/",$pdf_export.id)|ezurl} method="post" name="ExportPDF">

<table class="layout" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td valign="top">
    <!-- Main part start -->
    <div class="maincontentheader">
    <h1>{"PDF Export"|i18n("design/standard/content")}</h1>
    </div>

    <div class="block">

    <label>{"Title"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    {include uri="design:gui/lineedit.tpl" id_name="Title" value=$pdf_export.title|wash }
    <br/>

    <input type="checkbox" name="DisplayFrontpage" {section show=$pdf_export.show_frontpage|eq(1)}checked="checked"{/section}>{"Display frontpage"|i18n("design/standard/rss/edit")}</input>
    <br/>
    &nbsp;&nbsp;<label>{"Intro text"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    &nbsp;&nbsp;<textarea name="IntroText" cols="64" rows="3">{$pdf_export.intro_text|wash}</textarea>
    <br/>
    &nbsp;&nbsp;<label>{"Sub text"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    &nbsp;&nbsp;<textarea name="SubText" cols="64" rows="3">{$pdf_export.sub_text|wash}</textarea>
    <br/>    

    <label>{"Source node"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    <input type="text" readonly="readonly" size="45" value="{section show=$pdf_export.source_node}{$pdf_export.source_node..path_identification_string|wash}{/section}" maxlength="60" />
    {include uri="design:gui/button.tpl" id_name="ExportPDFBrowse" value="Browse"|i18n("design/standard/content")}
    <input type="hidden" name="SourceNode" value="{$pdf_export.source_node_id|wash}" />
    <br/>

    <label>{"Export structure"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    <input type="radio" name="ExportType" 
      {section show=$pdf_export.export_structure|eq("tree")} 
        checked="checked"
      {/section}
      value="tree">{"Tree"|i18n("design/standard/content")}</input>
    <br/>
    <input type="radio" name="ExportType" value="node">{"Node"|i18n("design/standard/content")}</input>
    <br/>
    
    <label>{"Export classes"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    <select name="ClassList[]" multiple="multiple" size="8">
    {section var=class loop=$export_class_array}
      <option value="{$class.item.id}" selected="selected">{$class.item.name|wash}</option>
    {/section}
    </select>
    <br/>

{*    <label>{"Site access"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    <select name="SiteAccess" size="1">
    {section var=site_access loop=$export_site_access}
      <option 
      {section show=$site_access.index|eq($pdf_export.site_access)}
        selected="selected"
      {/section}
      value="{$site_access.index}">{$site_access.item|wash}</option>
    {/section}
    </select>
    <br/> *}

    <label>{"Export destination"|i18n("design/standard/content")}</label><div class="labelbreak"></div>
    <input type="radio" name="DestinationType" value="url" checked="checked">{"Export to URL"|i18n("design/standard/content")}</input>
    {include uri="design:gui/lineedit.tpl" id_name="DestinationFile" value=$pdf_export.pdf_filename|wash }
    <br/>
    <input type="radio" name="DestinationType" value="download">{"Export for direct download"|i18n("design/standard/content")}</input>
    <br/>

    {include uri="design:gui/button.tpl" id_name=ExportPDFButton value="Export"|i18n("design/standard/content") }

    </td>
</tr>

</table>

</form>