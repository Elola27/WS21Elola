<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <HTML><BODY>
            <TABLE border="1">
                <THEAD>
                    <TR BGCOLOR="#60d394">
                        <TH>Eposta</TH>
                        <TH>Gaia</TH>
                        <TH>Galdera</TH>
                        <TH>Erantzun zuzena</TH>
                        <TH>Erantzun okerrak</TH>
                    </TR>
                </THEAD>
                <TBODY>
                    <xsl:for-each select="/assessmentItems/assessmentItem" >
                        <TR BGCOLOR="#caffbf">
                            <TD>
                                <FONT SIZE="2" FACE="Verdana">
                                    <xsl:value-of select="./@author"/> <BR/>
                                </FONT>
                            </TD>
                            <TD>
                                <FONT SIZE="2" FACE="Verdana">
                                    <xsl:value-of select="./@subject"/> <BR/>
                                </FONT>
                            </TD>
                                <TD>
                                    <FONT SIZE="2" FACE="Verdana">
                                        <xsl:value-of select="itemBody/p"/> <BR/>
                                    </FONT>
                                </TD>
                                <TD>
                                    <FONT SIZE="2" FACE="Verdana">
                                        <xsl:value-of select="correctResponse/response"/> <BR/>
                                    </FONT>
                                </TD>
                                <TD>
                                    <FONT SIZE="2" FACE="Verdana">
                                        <xsl:for-each select="incorrectResponses/response">
                                            <xsl:value-of select="."/> <BR></BR>
                                        </xsl:for-each>
                                    </FONT>
                                </TD>
                        </TR>
                    </xsl:for-each>
                </TBODY>
            </TABLE>
        </BODY></HTML></xsl:template>
</xsl:stylesheet>