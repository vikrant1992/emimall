package pom_files

import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import org.openqa.selenium.WebDriver
import org.openqa.selenium.By
import org.openqa.selenium.WebElement
import com.kms.katalon.core.annotation.Keyword
import com.kms.katalon.core.checkpoint.Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling
import com.kms.katalon.core.testcase.TestCase
import com.kms.katalon.core.testdata.TestData
import com.kms.katalon.core.testobject.TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI

import internal.GlobalVariable

public class PLPFilterOptions {

	int i;

	WebDriver driver;

	public PLPFilterOptions(WebDriver driver){
		this.driver=driver;
	}


	By filtersectionHeaders= By.xpath("//div[@class='filter-options']/div");

	By filterHeaders=By.xpath("//div[@class='filter-options']/div["+i+"]/div[1]");

	By brandOptions=By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li");
	
	By productName=By.xpath("//a[@class='product-item-link']");


	public int filterHeaders(){

		return driver.findElements(filtersectionHeaders).size();
	}

	public By headers(){

		return filterHeaders;
	}

	public By filteroptions(){

		return brandOptions;
	}
	
	public By productNames(){
		
		return productName;
	}
	
	
}
