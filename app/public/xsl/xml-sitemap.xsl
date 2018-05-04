<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
				xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>XML Sitemap</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>
				<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.15.14/jquery.tablesorter.min.js"></script>
				<script	type="text/javascript"><![CDATA[
					$(document).ready(function() { 
				        $("#sitemap").tablesorter( { widgets: ['zebra'] } ); 
					});
				]]></script>
				<style type="text/css">
					body {
						font-family: Helvetica, Arial, sans-serif;
						color: #545353;
					}
					table {
						width: 100%;
						margin-top: 25px;
						border: none;
						border-collapse: collapse;
						border-bottom: 1px solid #999;
					}
					#sitemap tr.odd {
						background-color: #eee;
					}
					#sitemap tbody tr:hover {
						background-color: #ccc;
					}
					#sitemap tbody tr:hover td, #sitemap tbody tr:hover td a {
						color: #333;
					}
					#content {
						margin: 3em auto 6em;
						max-width: 800px;
					}
					.expl {
						line-height: 1.5em;
					}
					a {
						color: #555;
						text-decoration: none;
					}
					a:visited {
						color: #777;
					}
					a:hover {
						text-decoration: underline;
					}
					td, th {
						font-size:11px;
						white-space: nowrap;
						text-align:left;
						padding: 6px;
					}
					th {
						border-bottom: 1px solid #999;
						cursor: pointer;
					}
					th:hover {
						background-color: #333;
						color: #FFF;
					}
					th span {
						font-weight: normal;
					}
					.change-frequency, .priority {
						display: none;
					}
					.images, .modified {
						text-align: center;
					}
				</style>
			</head>
			<body>
				<div id="content">
					<h1>XML Sitemap</h1>
					<table id="sitemap">
						<thead>
							<tr>
								<th width="75%">URL <span class="count">[<xsl:value-of select="count(sitemap:urlset/sitemap:url)"/>]</span></th>
								<th width="5%" class="priority">Priority</th>
								<th width="5%" class="change-frequency">Change Freq.</th>
								<th width="15%" class="modified">Last Change</th>
							</tr>
						</thead>
						<tbody>
							<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
							<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
							<xsl:for-each select="sitemap:urlset/sitemap:url">
								<tr>
									<td>
										<xsl:variable name="itemURL">
											<xsl:value-of select="sitemap:loc"/>
										</xsl:variable>
										<a href="{$itemURL}">
											<xsl:value-of select="sitemap:loc"/>
										</a>
									</td>
									<td class="priority">
										<xsl:value-of select="concat(sitemap:priority*100,'%')"/>
									</td>
									<td class="change-frequency">
										<xsl:value-of select="concat(translate(substring(sitemap:changefreq, 1, 1),concat($lower, $upper),concat($upper, $lower)),substring(sitemap:changefreq, 2))"/>
									</td>
									<td class="modified">
										<xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)))"/>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>