import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject

import org.testng.Assert
import plp.Resources
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable



//Verifying if the Element is present on the Page or not.
//Here we are Verifying if the Compare popup is present on the PLP page.
Assert.assertTrue(Resources.checkifComparepopuppresent());

String compareText=WebUI.getText(findTestObject("Object Repository/CompareFunctionality/ComparepopTextCapture"));

//Verifying that the Compare pop up is present on the Page as per the Journey
//of the user it should be present.
if(compareText.isEmpty())
{
	println('Compare Popup is not present on the PLP Page...!!!')
	Assert.assertTrue(false);

}

return compareText;