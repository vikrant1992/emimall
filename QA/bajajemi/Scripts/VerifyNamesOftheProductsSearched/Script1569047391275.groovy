import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject

import org.openqa.selenium.By
import org.openqa.selenium.WebDriver
import org.testng.Assert

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

WebDriver driver=DriverFactory.getWebDriver();

int size=Resources.getListofProducts();


for(int i=1;i<=size;i++){

String s=driver.findElement(By.xpath("//div[@class='mst-searchautocomplete__wrapper']/div/div/div[1]/ul/li["+i+"]")).getText();

driver.findElement(By.xpath("//div[@class='mst-searchautocomplete__wrapper']/div/div/div[1]/ul/li["+i+"]")).click();

String s1=WebUI.getText(findTestObject("Object Repository/CompareFunctionality/ProductName"));

println(s1);

Assert.assertEquals(s,s1);

WebUI.back();

WebUI.setText(findTestObject("Object Repository/Search/SearchinputFiled"), Resources.namesofProducts.get(1));

Thread.sleep(3000);
}