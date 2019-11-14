import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject

import java.util.concurrent.TimeUnit
import org.testng.Assert
import org.openqa.selenium.WebDriver
import org.openqa.selenium.By
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable
import plp.Resources



//@Author : Amit Baghel
//Date : 21/9/2019
//Test Case Description : In this test case i am getting the product that had been added to the Compare List.
//So the search will never return any null Value or else product not Found.

WebUI.setText(findTestObject("Object Repository/Search/SearchinputFiled"), Resources.namesofProducts.get(1));

Thread.sleep(3000);

WebDriver driver=DriverFactory.getWebDriver();

int list=Resources.getListofProducts();

//println(list);

if(list>5){
	//Verifying if not more than 5 products are loaded.
	//As depending upon the size of the List defined from Admin Panel.
	Assert.assertTrue(false);
}


//Verifying if the List obtained is not NUll.
Assert.assertNotNull(list);